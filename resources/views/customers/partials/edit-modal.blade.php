<!-- ==================EDIT CUSTOMER MODAL ====================== -->

<div class="modal fade"
     id="editCustomerModal{{ $customer->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <!-- HEADER -->

            <div class="modal-header border-0">

                <div>

                    <h5 class="modal-title fw-bold">

                        Edit Customer

                    </h5>

                    <small class="text-muted">

                        Update customer information

                    </small>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <!-- FORM -->

            <form method="POST"
                  action="{{ route('customers.update', $customer->id) }}">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="row g-3">

                        <!-- NAME -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Name

                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ $customer->name }}"
                                   class="form-control">

                        </div>

                        <!-- PHONE -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Phone

                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ $customer->phone }}"
                                   class="form-control">

                        </div>

                        <!-- PACKAGE -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Package

                            </label>

                            <select name="package_id"
                                    class="form-select">

                                @foreach($packages as $package)

                                    <option value="{{ $package->id }}"
                                        {{ $customer->package_id == $package->id ? 'selected' : '' }}>

                                        {{ $package->name }}

                                        -

                                        UGX {{ number_format($package->price) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <!-- ROUTER -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Router

                            </label>

                            <select name="mikrotik_device_id"
                                    class="form-select">

                                @foreach($routers as $router)

                                    <option value="{{ $router->id }}"
                                        {{ $customer->mikrotik_device_id == $router->id ? 'selected' : '' }}>

                                        {{ $router->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <!-- MAC -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                MAC Address

                            </label>

                            <input type="text"
                                   name="mac_address"
                                   value="{{ $customer->mac_address }}"
                                   class="form-control">

                        </div>

                        <!-- EXPIRY -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Expiry Date

                            </label>

                            <input type="datetime-local"
                                   name="expires_at"
                                   value="{{ optional($customer->expires_at)->format('Y-m-d\TH:i') }}"
                                   class="form-control">

                        </div>

                    </div>

                </div>

                <!-- FOOTER -->

                <div class="modal-footer border-0">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button class="btn btn-warning text-white">

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

