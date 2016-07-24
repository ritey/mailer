@extends('base')

@section('metas')
<title>Unsubscribed</title>
@endsection
@section('head')

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>

@endsection

@section('content')
    <div class="content">
        <div class="title">{{ $vars['email'] or 'You\'re' }} successfully unsubscribed</div>
    </div>
@endsection