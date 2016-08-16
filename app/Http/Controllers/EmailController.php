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
use Mailer\Library\Settings;
use Config;
use Mailgun;

class EmailController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Sites $sites, Log $log, Tags $tags, Emails $emails, Settings $settings)
	{
		$this->sites = $sites;
		$this->log = $log;
		$this->tags = $tags;
		$this->emails = $emails;
		$this->settings = $settings;
	}

	public function index()
	{
		$vars = [
			'legend' => 'Emails',
			'emails' => $this->emails->orderBy('created_at','DESC')->paginate(),
			'site_id' => '',
		];
		return view('emails',compact('vars'));
	}

	public function unsubscribe($id = '')
	{
		$site = '';
		if ($id) {
			$data = explode('|', $id);
			if (count($data) == 2) {
				$site = $this->sites->where('id',$data[1])->first();
				$email = $this->emails->where('email',trim(strtolower(base64_decode($data[0]))))->first();
				$result = $email->sites()->detach($data[1]);
				$result = $email->tags()->detach($email->id);
			}
		}

		$vars = [
			'email' => isset($data[0]) ? base64_decode($data[0]) : '',
			'site' => is_object($site) ? $site : '',
		];
		return view('unsubscribe',compact('vars'));
	}

	public function add($site_id)
	{
		$site = $this->sites->where('id',$site_id)->first();
		$vars = [
			'email' 	=> '',
			'legend' 	=> 'Add emails',
			'action' 	=> route('sites.emails.create', ['id' => $site_id]),
			'site_id'	=> $site_id,
			'site'		=> $site,
			'tags'		=> $site->tags,
		];
		return view('email_form',compact('vars'));
	}

	public function send($site_id)
	{
		$site = $this->sites->where('id',$site_id)->first();
		$config = $this->settings->getBySiteId($site_id);
		$vars = [
			'email' 	=> '',
			'legend' 	=> 'Send email',
			'action' 	=> route('sites.emails.mail', ['id' => $site_id]),
			'tags'		=> $site->tags,
			'site_id'	=> $site_id,
			'site'		=> $site,
			'config'	=> $config,
		];
		return view('mail_form',compact('vars'));
	}

	public function mail(MailRequest $request, $site_id)
	{
		$config = $this->settings->getBySiteId($site_id);

		foreach($config['all'] as $item) {
			switch($item['name']) {
				case 'MAILGUN_FROM_ADDRESS': Config::set('mailgun.from.address',$item['value']); break;
				case 'MAILGUN_FROM_NAME': Config::set('mailgun.from.name',$item['value']); break;
				case 'MAILGUN_REPLY_TO': Config::set('mailgun.reply_to',$item['value']); break;
				case 'MAILGUN_SECRET': Config::set('mailgun.api_key',$item['value']); break;
				case 'MAILGUN_PUBLIC': Config::set('mailgun.public_api_key',$item['value']); break;
				case 'MAILGUN_DOMAIN': Config::set('mailgun.domain',$item['value']); break;
				case 'MAILGUN_FORCE_FROM_ADDRESS': Config::set('mailgun.force_from_address',$item['value']); break;
				case 'MAILGUN_CATCH_ALL': Config::set('mailgun.catch_all',$item['value']); break;
			}
		}

		$tags = explode(',',$request->input('tag'));

		foreach($tags as $tag) {

			$tag = $this->tags->where('name',strtolower(trim($tag)))->first();

			foreach($tag->emails as $email) {

				foreach($email->sites as $site) {

					if ($site->id == $site_id) {

						$data['email'] = $email->email;
						$unsubscribe_link = "To unsubscribe click here: " . route('unsubscribe' , [ 'id' => base64_encode($data['email']).'|'.$site_id]);
						$data['subject'] = $request->input('subject');
						$data['html'] = $request->input('message') . "<p align=\"center\">".$unsubscribe_link."</p>";
						$data['text'] = $request->input('plain_message') . "\n\n\n" . $unsubscribe_link;

						$result = Mailgun::send(['emails.email', 'emails.text'], $data, function($message) use ($data)
						{
						    $message->to($data['email'])->subject($data['subject']);
						});

						$this->log->create(['name' => 'Email sent ['.$data['email'].']', 'value' => json_encode($result), 'created_at' => date('Y-m-d H:i:s')]);

					}
				}
			}
		}

		return redirect()->route('sites.emails.directory', ['id' => $site_id]);
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
					$tag_data->sites()->attach($site_id, ['created_at' => date('Y-m-d H:i:s')]);
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

	public function emails($site_id, $tag = '')
	{
		$site = $this->sites->where('id',$site_id)->first();
		//$emails = $this->sites->where('id',$site_id)->first()->emails;
		$emails = $this->emails
					->whereHas('sites', function($query) use($site_id) {
						$query->where('site_id','=',$site_id);
					});
		if (!empty($tag)) {
			$emails = $this->emails
					->whereHas('sites', function($query) use($site_id) {
						$query->where('site_id','=',$site_id);
					})->whereHas('tags', function($query) use($tag) {
						$query->where('tags.name','=',$tag);
					});
		}
		$emails = $emails->get();
		$vars = [
			'legend' 	=> 'Emails',
			'emails' 	=> $emails,
			'site_id' 	=> $site_id,
			'site'		=> $site,
			'tags'		=> $site->tags,
			'tag'		=> $tag,
		];
		return view('emails',compact('vars'));
	}

}