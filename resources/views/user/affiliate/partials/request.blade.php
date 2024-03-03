<div class="col-lg-12">
    <div class="customers__area bg-style mb-30">
        <ul class="nav nav-tabs zTab-reset zTab-one" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active orderStatusTab text-1b1c17" data-bs-toggle="tab" data-bs-target="#allTabPane"
                        type="button" data-status="All" role="tab" aria-controls="allTabPane"
                        aria-selected="true">{{ __('All') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link orderStatusTab text-1b1c17" data-bs-toggle="tab" data-bs-target="#paidTabPane"
                        type="button" role="tab" data-status="Paid" aria-controls="paidTabPane"
                        aria-selected="false" tabindex="-1">{{ __('Approved') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link orderStatusTab text-1b1c17" data-bs-toggle="tab" data-status="Pending"
                        data-bs-target="#pendingTabPane" type="button" role="tab"
                        aria-controls="pendingTabPane" aria-selected="false" tabindex="-1">{{ __('Pending') }}
                </button>
            </li>
            <li class="nav-item" role="presentation ">
                <button class="nav-link orderStatusTab text-1b1c17" data-bs-toggle="tab" data-bs-target="#cancelTabPane"
                        type="button" role="tab" aria-controls="cancelTabPane" data-status="Cancelled"
                        aria-selected="false" tabindex="-1">{{ __('Cancelled') }}
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="allTabPane" role="tabpanel" aria-labelledby="all-tab"
                 tabindex="0">
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="AllWithdrawRequestDataTable" aria-describedby="allWithdrawRequestDataTable">
                        <thead>
                            <tr>
                                <th>
                                    <div>{{ __('#SL') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Date') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Payment Details') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Amount') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Status') }}</div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="paidTabPane" role="tabpanel" aria-labelledby="paid-tab"
                 tabindex="0">
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="PaidWithdrawRequestDataTable"
                           aria-describedby="PaidWithdrawRequestDataTable">
                        <thead>
                            <tr>
                                <th>
                                    <div>{{ __('#SL') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Date') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Payment Details') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Amount') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Status') }}</div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="pendingTabPane" role="tabpanel" aria-labelledby="pending-tab"
                 tabindex="0">
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="PendingWithdrawRequestDataTable"
                           aria-describedby="PendingWithdrawRequestDataTable">
                        <thead>
                            <tr>
                                <th>
                                    <div>{{ __('#SL') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Date') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Payment Details') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Amount') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Status') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Action') }}</div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="cancelTabPane" role="tabpanel"
                 aria-labelledby="cancel-tab"tabindex="0">
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="CancelledWithdrawRequestDataTable"
                           aria-describedby="CancelledWithdrawRequestDataTable">
                        <thead>
                            <tr>
                                <th>
                                    <div>{{ __('#SL') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Date') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Payment Details') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Amount') }}</div>
                                </th>
                                <th>
                                    <div>{{ __('Status') }}</div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
