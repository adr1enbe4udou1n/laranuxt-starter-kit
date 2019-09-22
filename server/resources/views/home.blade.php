@extends('layouts.main')

@section('content')
    <div id="app"></div>

    @routes

    <script type="application/json" data-settings-selector="settings-json">
        {!! json_encode($data) !!}
    </script>
@endsection
