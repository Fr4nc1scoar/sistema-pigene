@extends('layouts.app')

@section('content')
@include('salary_scales.create', ['salaryScale' => $salaryScale])
@endsection
