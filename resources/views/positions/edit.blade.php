@extends('layouts.app')

@section('content')
@include('positions.create', ['position' => $position])
@endsection
