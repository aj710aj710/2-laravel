@extends('user.layouts.app')
@push('title')
    {{ __('Create Ticket') }}
@endpush
@section('content')
    <!-- Right Content Start -->
    <div class="main-content">
        <div class="page-content">
            <!-- dashboard area start -->

            <section class="dashboard-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard-box">
                                <div class="title-area">
                                    <div class="dashboard-text">
                                        <h2>{{$pageTitle}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- dashboard area end -->


            <!-- Create Ticket start-->
            <section class="view-ticket-area">
                <div class="container-fluid">
                    <div class="singleDateNotifi">
                        <div class="row">
                            @foreach(userNotification('seen-unseen') as $key=>$item)
                                <div class="col-md-6">

                                    <div class="singleNotifi">
                                        <div class="notifiUser">
                                            <img src="{{asset('agent/assets/images/email.png')}}"
                                                 class="rounded-circle avatar-xs" alt="user-pic">
                                        </div>
                                        <div class="notifiInfoText">

                                            <div class="notifiTitle">
                                                <a href="{{route('agent.notification-view',$item->id)}}">
                                                    @if($item->seen_id == null)
                                                        <h5>{{$item->title}}</h5>
                                                    @else
                                                        <h5 class="text-dark-color">{{$item->title}}</h5>
                                                    @endif
                                                </a>
                                                <div class="notifiTime">
                                                    <p>{{$item->created_at?->diffForHumans()}}</p>
                                                    <span class="iconNotifi">
                                                      <span class="ellipsisDote">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                      </span>
                                                      <div class="editPart">
                                                           <a href="{{route('agent.notification-delete',$item->id)}}">
                                                        <div class="coustomPart">
                                                          <span>Delete</span>
                                                          <span><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" viewBox="0 0 16 16"
                                                                     fill="none">
                                                              <path d="M2 4H3.33333H14" stroke="#737C90"
                                                                    stroke-width="1.4" stroke-linecap="round"
                                                                    stroke-linejoin="round"/>
                                                              <path
                                                                  d="M5.33203 4.00004V2.66671C5.33203 2.31309 5.47251 1.97395 5.72256 1.7239C5.9726 1.47385 6.31174 1.33337 6.66536 1.33337H9.33203C9.68565 1.33337 10.0248 1.47385 10.2748 1.7239C10.5249 1.97395 10.6654 2.31309 10.6654 2.66671V4.00004M12.6654 4.00004V13.3334C12.6654 13.687 12.5249 14.0261 12.2748 14.2762C12.0248 14.5262 11.6857 14.6667 11.332 14.6667H4.66536C4.31174 14.6667 3.9726 14.5262 3.72256 14.2762C3.47251 14.0261 3.33203 13.687 3.33203 13.3334V4.00004H12.6654Z"
                                                                  stroke="#737C90" stroke-width="1.4"
                                                                  stroke-linecap="round"
                                                                  stroke-linejoin="round"/>
                                                              <path d="M6.66797 7.33337V11.3334" stroke="#737C90"
                                                                    stroke-width="1.4"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                              <path d="M9.33203 7.33337V11.3334" stroke="#737C90"
                                                                    stroke-width="1.4"
                                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg></span>
                                                        </div>
                                                           </a>
                                                          <a href="{{route('agent.notification-view',$item->id)}}">
                                                        <div class="coustomPart">
                                                          <span>View</span>
                                                          <span><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" viewBox="0 0 16 16"
                                                                     fill="none">
                                                              <g clip-path="url(#clip0_829_2367)">
                                                                <path
                                                                    d="M8.0013 12.6667C12.0515 12.6667 15.3346 8 15.3346 8C15.3346 8 12.0515 3.33334 8.0013 3.33334C3.9511 3.33334 0.667969 8 0.667969 8C0.667969 8 3.9511 12.6667 8.0013 12.6667Z"
                                                                    stroke="#737C90" stroke-width="1.4"
                                                                    stroke-linejoin="round"/>
                                                                <path
                                                                    d="M8 10C8.53043 10 9.03914 9.78929 9.41421 9.41422C9.78929 9.03914 10 8.53044 10 8C10 7.46957 9.78929 6.96086 9.41421 6.58579C9.03914 6.21072 8.53043 6 8 6C7.46957 6 6.96086 6.21072 6.58579 6.58579C6.21071 6.96086 6 7.46957 6 8C6 8.53044 6.21071 9.03914 6.58579 9.41422C6.96086 9.78929 7.46957 10 8 10Z"
                                                                    stroke="#737C90" stroke-width="1.4"
                                                                    stroke-linejoin="round"/>
                                                              </g>
                                                              <defs>
                                                                <clipPath id="clip0_829_2367">
                                                                  <rect width="16" height="16" fill="white"/>
                                                                </clipPath>
                                                              </defs>
                                                            </svg></span>
                                                        </div>
                                                          </a>
                                                      </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="notifiText">{{Str::of(strip_tags($item->body))->limit(50)}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <span id="notfioverlay"></span>


            </section>


            <!-- Create Ticket end-->
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('agent/assets/js/custom/notification.js')}}"></script>
@endpush
