<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Mailer\Requests\MailRequest;
use Mailer\Requests\EmailsRequest;
use Mailer\Models\Sites;
use Mailer\Models\Log;
use Mailer\Models\Tags;
use Mailer\Models\Emails;
use Config;
use Mailgun;

class EmailController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Sites $sites, Log $log, Tags $tags, Emails $emails)
	{
		$this->sites = $sites;
		$this->log = $log;
		$this->tags = $tags;
		$this->emails = $emails;
	}

	public function add($site_id)
	{
		$vars = [
			'email' 	=> '',
			'legend' 	=> 'Add emails',
			'action' 	=> route('sites.emails.create', ['id' => $site_id]),
		];
		return view('email_form',compact('vars'));
	}

	public function send($site_id)
	{
		$vars = [
			'email' 	=> '',
			'legend' 	=> 'Send email',
			'action' 	=> route('sites.emails.mail', ['id' => $site_id]),
		];
		return view('mail_form',compact('vars'));
	}

	public function mail(MailRequest $request, $site_id)
	{
		Config::set('MAILGUN_FROM_ADDRESS','noreply@nationalfundingscheme.org');
		Config::set('MAILGUN_FROM_NAME','DONATE');
		Config::set('MAILGUN_REPLY_TO','hello@nationalfundingscheme.org');
		Config::set('MAILGUN_SECRET','key-9r9325pw2gsbmm41elncacgz977q9vu6');
		Config::set('MAILGUN_PUBLIC','');
		Config::set('MAILGUN_DOMAIN','nationalfundingscheme.org');
		Config::set('MAILGUN_FORCE_FROM_ADDRESS','noreply@nationalfundingscheme.org');
		Config::set('MAILGUN_CATCH_ALL','admin@nationalfundingscheme.org');
		Config::set('MAILGUN_TEST_MODE','0');

		$data['email'] = 'david.wright@panlogic.co.uk';
		$data['subject'] = 'Testing mailer';
		$data['html'] = '<h1>Hello</h1>';
		$data['text'] = 'Hello';

		Mailgun::send(['html' => 'emails.email', 'text' => 'emails.text'], $data, function($message) use ($data)
		{
		    $message->to($data['email'])->subject($data['subject']);
		});

		dd('Sent');
	}

	public function create(EmailsRequest $request, $site_id)
	{
		$tag_ids = [];
		$tags_created = 0;
		$emails_created = 0;
		$emails_assigned = 0;
		$tags_assigned = 0;
		$tags = explode(',', $request->input('tags'));
		if (count($tags)) {
			foreach($tags as $tag) {
				$tag_data = $this->tags->where('name',trim(strtolower($tag)))->first();
				if ($tag_data) {
					$tag_ids[] = $tag_data->id;
					$tags_assigned++;
				} else {
					$tag_data = $this->tags->create(['name' => trim(strtolower($tag)), 'created_at' => date('Y-m-d H:i:s')]);
					$tag_ids[] = $tag_data->id;
					$tags_created++;
				}
			}
		}

		$emails = explode(',', $request->input('emails'));

		if ($request->hasFile('email_file')) {
			$email_csv = $request->file('email_file');
			$filename = md5(date('Y-m-d H:i:s')) . '.' . $email_csv->
getClientOriginalExtension();
			$request->file('email_file')->move(storage_path() . '/uploads', $filename);
			$file_handle = fopen(storage_path() . '/uploads/' . $filename ,"r");
			do {
				if (isset($data) && !empty($data) && !empty($data[0])) {
					$emails[] = strtolower(trim($data[0]));
				}
			} while ($data = fgetcsv($file_handle,1000,',','"',"'"));
		}

		$emails = array_filter($emails);
		$emails = array_unique($emails);

		if (count($emails)) {
			foreach($emails as $email) {
				$email_data = $this->emails->where('email',trim(strtolower($email)))->first();
				if ($email_data) {
					$email_ids[] = $email_data->id;
					$this->addTags($email_data,$tag_ids);
					$email_data->sites()->attach($site_id, ['created_at' => date('Y-m-d H:i:s')]);
					$emails_assigned++;
				} else {
					$email_data = $this->emails->create(['email' => trim(strtolower($email)), 'created_at' => date('Y-m-d H:i:s')]);
					$email_data->sites()->attach($site_id, ['created_at' => date('Y-m-d H:i:s')]);
					$this->addTags($email_data,$tag_ids);
					$email_ids[] = $email_data->id;
					$emails_created++;
				}
			}
		}

		$message = sprintf("Tags created %s. Tags assigned %s. Emails created %s. Emails assigned %s. Related site: %s", $tags_created, $tags_assigned, $emails_created, $emails_assigned, $site_id);

		$this->log->create(['name' => 'Email added', 'value' => $message, 'created_at' => date('Y-m-d H:i:s')]);

		return redirect()->route('sites.emails.directory', ['id' => $site_id]);
	}

	private function addTags($email, $tags)
	{
		foreach($tags as $tag_id) {
			$email->tags()->attach($tag_id, ['created_at' => date('Y-m-d H:i:s')]);
		}
	}

	public function emails($site_id)
	{
		$vars = [
			'legend' => 'Emails',
			'emails' => $this->sites->where('id',$site_id)->first()->emails,
		];
		return view('emails',compact('vars'));
	}

}