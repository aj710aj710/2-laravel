@extends('user.layouts.app')
@push('title')
    {{ __('Create Ticket') }}
@endpush
@section('content')
    <!-- Content -->
    <div class="px-24 pb-24 position-relative">
        <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-20">
            <div class="">
            <h4 class="fs-24 fw-500 lh-24 text-white"></h4>
            </div>
        </div>
        <div class="p-20 bd-one bd-c-stroke-color bd-ra-12 bg-white overflow-hidden">
            <div class="d-flex align-items-start cg-15">
            <div class="flex-grow-0 flex-shrink-0 w-32 h-32 rounded-circle d-flex justify-content-center align-items-center bg-color6">
                <img src="{{asset('user/images/icon/bell-white.svg')}}" alt="" /></div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center pb-8">
                <p class="fs-14 fw-500 lh-16 text-textBlack">{{ $singleNotification->title }}</p>
                <p class="fs-10 fw-400 lh-20 text-para-text"> {{ $singleNotification->created_at?->diffForHumans() }}</p>
                </div>
                <p class="fs-12 fw-400 lh-17 text-para-text col-xl-11">
                {!! $singleNotification->body !!}
                </p>
            </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('agent/assets/js/custom/notification.js')}}"></script>
@endpush
