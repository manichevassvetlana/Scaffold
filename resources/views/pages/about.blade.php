@extends('layouts.'.$page->getRelatedName('layout'))
@section('title', $page->title)
@section('meta-description', $page->meta_description)
@section('meta-keywords', $page->meta_keywords)
@section('content')
    {!! $page->content !!}
@endsection