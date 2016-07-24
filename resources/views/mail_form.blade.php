@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('head')
<style type="text/css">
/* Overlay style */
.overlay {
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	background: rgba(255,255,255,0.9);
}

/* Overlay closing cross */
.overlay .overlay-close {
	width: 80px;
	height: 80px;
	position: absolute;
	right: 20px;
	top: 20px;
	overflow: hidden;
	border: none;
	background: url(/images/cross.png) no-repeat center center;
	text-indent: 200%;
	color: transparent;
	outline: none;
	z-index: 100;
}

/* Menu style */
.overlay nav {
	text-align: center;
	position: relative;
	top: 50%;
	height: 60%;
	-webkit-transform: translateY(-50%);
	transform: translateY(-50%);
}

.overlay ul {
	list-style: none;
	padding: 0;
	margin: 0 auto;
	display: inline-block;
	height: 100%;
	position: relative;
}

.overlay ul li {
	display: block;
	height: 20%;
	height: calc(100% / 5);
	min-height: 54px;
	-webkit-backface-visibility: hidden;
	backface-visibility: hidden;
}

.overlay ul li a {
	font-size: 54px;
	font-weight: 300;
	display: block;
	color: #fff;
	-webkit-transition: color 0.2s;
	transition: color 0.2s;
}

.overlay ul li a:hover,
.overlay ul li a:focus {
	color: #f0f0f0;
}

/* Effects */
.overlay-scale {
	visibility: hidden;
	opacity: 0;
	-webkit-transform: scale(0.9);
	transform: scale(0.9);
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s, visibility 0s 0.2s;
	transition: transform 0.2s, opacity 0.2s, visibility 0s 0.2s;
}

.overlay-scale.open {
	visibility: visible;
	opacity: 1;
	-webkit-transform: scale(1);
	transform: scale(1);
	-webkit-transition: -webkit-transform 0.4s, opacity 0.4s;
	transition: transform 0.4s, opacity 0.4s;
}

@media screen and (max-height: 30.5em) {
	.overlay nav {
		height: 70%;
		font-size: 34px;
	}
	.overlay ul li {
		min-height: 34px;
	}
}
</style>
@endsection

@section('content')

	<div class="col-md-12">
		<a href="{{ route('sites.home', ['id' => $vars['site_id']]) }}">{{ $vars['site']->name }} options</a>
		<hr />
	</div>

	<div class="col-md-12">

		<form method="post" action="{{ $vars['action'] }}" class="form-horizontal" enctype="multipart/form-data">

			<legend>{{ $vars['legend'] }}</legend>

			{!! csrf_field() !!}

			<div class="form-group">
				<label for="tag" class="col-sm-2 control-label">Send to list:</label>
				<div class="col-sm-10 ">
					<input type="text" class="form-control" name="tag" id="tag" value="">
					<p class="help-block">Lists:
						@foreach($vars['tags'] as $tag)
							<a class="tag" href="#{{ $tag->name }}">{{ $tag->name }}</a>
						@endforeach
					</p>
					<p class="help-block">Comma seperate lists if multiples are being added</p>
				</div>
			</div>

			<hr />

			<div class="form-group">
				<label for="subject" class="col-sm-2 control-label">Subject</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="subject" autocomplete="false" id="subject" value="">
				</div>
			</div>

			<div class="form-group">
				<label for="message" class="col-sm-2 control-label">HTML Message</label>
				<div class="col-sm-10 ">
					<textarea name="message" rows="5" id="message" class="form-control"></textarea>
					<p class="help-block">Templates:
						@foreach($vars['config']['all'] as $config)
							@if($config['class'] == 'template')
							<a class="template" href="#{{ $config['name'] }}">{{ $config['name'] }} <textarea class="hidden">{{ $config['value'] }}</textarea></a>
							@endif
						@endforeach
						<button class="pull-right btn btn-info" id="trigger-overlay" type="button">Preview</button>
					</p>
				</div>
			</div>

			<div class="form-group">
				<label for="plain_message" class="col-sm-2 control-label">Plain Text Message</label>
				<div class="col-sm-10 ">
					<textarea name="plain_message" rows="5" id="plain_message" class="form-control"></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</form>

		<!-- open/close -->
		<div class="overlay overlay-scale">
			<button type="button" class="overlay-close">Close</button>
			<div id="preview" style="display:block;"></div>
		</div>

	</div>

@endsection

@section('footer')
	<script type="text/javascript">

/* Modernizr 2.7.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransitions-shiv-cssclasses-prefixed-testprop-testallprops-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function x(a){j.cssText=a}function y(a,b){return x(prefixes.join(a+";")+(b||""))}function z(a,b){return typeof a===b}function A(a,b){return!!~(""+a).indexOf(b)}function B(a,b){for(var d in a){var e=a[d];if(!A(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function C(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:z(f,"function")?f.bind(d||b):f}return!1}function D(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+n.join(d+" ")+d).split(" ");return z(b,"string")||z(b,"undefined")?B(e,b):(e=(a+" "+o.join(d+" ")+d).split(" "),C(e,b,c))}var d="2.7.1",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m="Webkit Moz O ms",n=m.split(" "),o=m.toLowerCase().split(" "),p={},q={},r={},s=[],t=s.slice,u,v={}.hasOwnProperty,w;!z(v,"undefined")&&!z(v.call,"undefined")?w=function(a,b){return v.call(a,b)}:w=function(a,b){return b in a&&z(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=t.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(t.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(t.call(arguments)))};return e}),p.csstransitions=function(){return D("transition")};for(var E in p)w(p,E)&&(u=E.toLowerCase(),e[u]=p[E](),s.push((e[u]?"":"no-")+u));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)w(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},x(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._domPrefixes=o,e._cssomPrefixes=n,e.testProp=function(a){return B([a])},e.testAllProps=D,e.prefixed=function(a,b,c){return b?D(a,b,c):D(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+s.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};

	$('document').ready(function() {
		$('.tag').on('click',function(e) {
			e.preventDefault();
			$val = $('#tag').val();
			if ($val && $val != $(this).html()) {
				$('#tag').val($val + ',' + $(this).html());
			} else {
				$('#tag').val($(this).html());
			}
		});
		$('.template').on('click',function(e) {
			e.preventDefault();
			$('#message').val($('textarea',this).val());
		});

		/*!
		 * classie - class helper functions
		 * from bonzo https://github.com/ded/bonzo
		 *
		 * classie.has( elem, 'my-class' ) -> true/false
		 * classie.add( elem, 'my-new-class' )
		 * classie.remove( elem, 'my-unwanted-class' )
		 * classie.toggle( elem, 'my-class' )
		 */

		/*jshint browser: true, strict: true, undef: true */
		/*global define: false */

		( function( window ) {

		'use strict';

		// class helper functions from bonzo https://github.com/ded/bonzo

		function classReg( className ) {
		  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
		}

		// classList support for class management
		// altho to be fair, the api sucks because it won't accept multiple classes at once
		var hasClass, addClass, removeClass;

		if ( 'classList' in document.documentElement ) {
		  hasClass = function( elem, c ) {
		    return elem.classList.contains( c );
		  };
		  addClass = function( elem, c ) {
		    elem.classList.add( c );
		  };
		  removeClass = function( elem, c ) {
		    elem.classList.remove( c );
		  };
		}
		else {
		  hasClass = function( elem, c ) {
		    return classReg( c ).test( elem.className );
		  };
		  addClass = function( elem, c ) {
		    if ( !hasClass( elem, c ) ) {
		      elem.className = elem.className + ' ' + c;
		    }
		  };
		  removeClass = function( elem, c ) {
		    elem.className = elem.className.replace( classReg( c ), ' ' );
		  };
		}

		function toggleClass( elem, c ) {
		  var fn = hasClass( elem, c ) ? removeClass : addClass;
		  fn( elem, c );
		}

		var classie = {
		  // full names
		  hasClass: hasClass,
		  addClass: addClass,
		  removeClass: removeClass,
		  toggleClass: toggleClass,
		  // short names
		  has: hasClass,
		  add: addClass,
		  remove: removeClass,
		  toggle: toggleClass
		};

		// transport
		if ( typeof define === 'function' && define.amd ) {
		  // AMD
		  define( classie );
		} else {
		  // browser global
		  window.classie = classie;
		}

		})( window );

		(function() {
			var triggerBttn = document.getElementById( 'trigger-overlay' ),
				overlay = document.querySelector( 'div.overlay' ),
				closeBttn = overlay.querySelector( 'button.overlay-close' );
				transEndEventNames = {
					'WebkitTransition': 'webkitTransitionEnd',
					'MozTransition': 'transitionend',
					'OTransition': 'oTransitionEnd',
					'msTransition': 'MSTransitionEnd',
					'transition': 'transitionend'
				},
				transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
				support = { transitions : Modernizr.csstransitions };

			function toggleOverlay() {
				if( classie.has( overlay, 'open' ) ) {
					classie.remove( overlay, 'open' );
					classie.add( overlay, 'close' );
					var onEndTransitionFn = function( ev ) {
						if( support.transitions ) {
							if( ev.propertyName !== 'visibility' ) return;
							this.removeEventListener( transEndEventName, onEndTransitionFn );
						}
						classie.remove( overlay, 'close' );
					};
					if( support.transitions ) {
						overlay.addEventListener( transEndEventName, onEndTransitionFn );
					}
					else {
						onEndTransitionFn();
					}
					$('#preview').html('');
				}
				else if( !classie.has( overlay, 'close' ) ) {
					classie.add( overlay, 'open' );
					$('#preview').html($('#message').val());
				}
			}

			triggerBttn.addEventListener( 'click', toggleOverlay );
			closeBttn.addEventListener( 'click', toggleOverlay );
		})();
	});
	</script>
@endsection