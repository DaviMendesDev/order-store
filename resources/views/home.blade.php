@extends('layouts.mainLayout')

@section('title', __('Add Order'))

@section('content')
  <home listing-route="{{ route('orders.list') }}" add-route="{{ route('orders.store') }}"></home>
@endsection
