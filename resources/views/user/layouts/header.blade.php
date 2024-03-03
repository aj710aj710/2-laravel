<div class="main-header position-relative py-30 px-24 d-flex justify-content-between align-items-center">
    <!-- Left -->
    <div class="left flex-grow-1 flex-shrink-1 d-flex align-items-center cg-15">
        <!-- Mobile Menu Button -->
        <div class="mobileMenu">
            <button
                class="bd-one bd-c-white rounded-circle w-40 h-40 d-flex justify-content-center align-items-center text-white p-0 bg-transparent">
                <i class="fa-solid fa-bars"></i></button>
        </div>
        <!-- Search -->
        <div class="d-none d-sm-block">
            <h4 class="fs-24 fw-500 lh-24 text-white">{{ __(@$pageTitle) }}</h4>
        </div>
        <!-- Title -->
    </div>
    <!-- Right -->
    <div class="right d-flex justify-content-end align-items-center">
        <!-- Notify - User -->
        <div class="d-flex align-items-center cg-10">
            <!-- Language switcher -->
            @if (!empty(getOption('show_language_switcher')) && getOption('show_language_switcher') == STATUS_ACTIVE)
                <div class="dropdown headerUserDropdown lanDropdown">
                    <button class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="flex-shrink-0 w-40 h-40 rounded-circle bg-white overflow-hidden bd-one bd-c-black-5 bg-fafafa d-flex justify-content-center align-items-center">
                            <img class="max-w-26" src="{{ asset(selectedLanguage()?->flag) }}" alt=""/></div>
                        <div class="text-start d-none d-md-block">
                            <h4 class="fs-15 fw-500 lh-18 text-1b1c17">{{ selectedLanguage()?->language }}</h4>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdownItem-one">
                        @foreach (appLanguages() as $app_lang)
                        <li>
                            <a class="d-flex align-items-center cg-8" href="{{ url('/local/' . $app_lang->iso_code) }}">
                                <div class="d-flex">
                                    <img src="{{ asset($app_lang->flag) }}" alt="" class="max-w-26"/>
                                </div>
                                <p class="fs-14 fw-500 lh-16 text-707070">{{ $app_lang->language }}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <!--End Language switcher -->
            <!-- Notify -->
            <div class="dropdown notifyDropdown">
                <button class="item-one dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('user')}}/images/icon/bell-3.svg" alt=""/>
                    <span class="notify_no">{{__(count(userNotification('unseen')))}}</span>
                </button>
                <div class="dropdown-menu">
                    <div class="d-flex justify-content-between align-items-center bd-b-one bd-c-stroke-2-color mx-15 px-0 pb-3">
                        <h4 class="fs-18 fw-600 lh-32 text-textBlack">
                            @if (count(userNotification('seen-unseen')) > 0)
                                {{ __('Today') }}
                            @else
                                {{ __('Notification Not Found!') }}
                            @endif
                        </h4>
                        @if (count(userNotification('unseen')) > 0)
                            <a href="{{ route('user.notification.notification-mark-all-as-read') }}"
                            class="fs-12 fw-600 lh-20 text-textBlack text-decoration-underline border-0 p-0 bg-transparent hover-color-one">{{ __('Mark all as read') }}</a>
                        @endif
                    </div>
                    <ul class="notify-list">
                        @foreach(userNotification('seen-unseen') as $key=>$item)
                            <li class="d-flex align-items-start cg-15">
                                <div
                                    class="flex-grow-0 flex-shrink-0 w-32 h-32 rounded-circle d-flex justify-content-center align-items-center bg-color6">
                                    <img src="{{asset('user/images/icon/bell-white.svg')}}" alt=""/></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center pb-8">
                                        @if($item->seen_id == null)
                                            <p class="fs-14 fw-500 lh-16 text-textBlack fw-700">{{$item->title}}</p>
                                        @else
                                            <p class="fs-14 fw-500 lh-16 text-textBlack text-dark-color">{{$item->title}}</p>
                                        @endif
                                        <p class="fs-10 fw-400 lh-20 text-para-text">{{$item->created_at?->diffForHumans()}}</p>
                                    </div>
                                    @if($item->seen_id == null)
                                        <p class="fs-12 lh-17 text-para-text max-w-220 fw-700">{{$item->body}}
                                    @else
                                        <p class="fs-12 fw-400 lh-17 text-para-text max-w-220">{{$item->body}}
                                    @endif
                                        <a
                                            href="{{route('user.notification.view',$item->id)}}"
                                            class="text-textBlack text-decoration-underline hover-color-one">{{__('See
                                        More')}}</a>
                                        </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- User -->
            <div class="dropdown headerUserDropdown">
                <button class="dropdown-toggle p-0 border-0 bg-transparent d-flex align-items-center cg-8" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="w-40 h-40 rounded-circle overflow-hidden"><img src="{{ asset(getFileUrl(auth()->user()->image)) }}" alt="{{ auth()->user()->name }}"/></div>
                </button>
                <ul class="dropdown-menu dropdownItem-one">
                    <li>
                        <a class="d-flex align-items-center cg-8" href="{{ route('user.settings') }}">
                            <div class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path
                                        d="M16.4397 17.0389C16.0598 15.9757 15.2229 15.0363 14.0586 14.3662C12.8943 13.6962 11.4677 13.333 10.0002 13.333C8.5326 13.333 7.10605 13.6962 5.94175 14.3662C4.77746 15.0363 3.94049 15.9757 3.56066 17.0389"
                                        stroke="#596680" stroke-width="1.5" stroke-linecap="round"/>
                                    <ellipse cx="9.99984" cy="6.66634" rx="3.33333" ry="3.33333" stroke="#596680"
                                             stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <p class="">{{__("Profile")}}</p>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center cg-8" href="{{ route('logout') }}">
                            <div class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                     fill="none">
                                    <path
                                        d="M7.66667 14.3333C5.89856 14.3333 4.20286 13.631 2.95262 12.3807C1.70238 11.1305 1 9.43478 1 7.66667C1 5.89856 1.70238 4.20286 2.95262 2.95262C4.20286 1.70238 5.89856 1 7.66667 1"
                                        stroke="#596680" stroke-width="1.5" stroke-linecap="round"/>
                                    <path
                                        d="M6 7.66663H14.3333M14.3333 7.66663L11.8333 5.16663M14.3333 7.66663L11.8333 10.1666"
                                        stroke="#596680" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <p class="">{{__("Logout")}}</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
