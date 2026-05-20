@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')

@section('content')

      <main class="dashboard-content">

<div class="p-6 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">IAMTEK Dashboard</h1>
        <p class="text-gray-500">Real-time ISP & Voucher Analytics</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- My Vouchers -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-gray-500">My Vouchers.</p>
            <h2 class="text-3xl font-bold mt-2">{{ $myVouchers }}</h2>
        </div>

        <!-- Used -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
            <p class="text-gray-500">Used Vouchers</p>
            <h2 class="text-3xl font-bold mt-2">{{ $usedVouchers }}</h2>
        </div>

        <!-- Active Sessions -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-gray-500">Active Users</p>
            <h2 class="text-3xl font-bold mt-2">{{ $activeVouchers }}</h2>
        </div>

        <!-- Routers -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-orange-500">
            <p class="text-gray-500">Routers</p>
            <h2 class="text-3xl font-bold mt-2">{{ $routers }}</h2>
        </div>

    </div>

    <!-- Analytics Section -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Chart Placeholder -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">Usage Analytics</h3>
            <div class="h-64 flex items-center justify-center text-gray-400">
                Chart (integrate Chart.js / ApexCharts)
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">Recent Activity</h3>
            <ul class="space-y-3 text-sm text-gray-600">
                <li>Voucher created successfully</li>
                <li> User logged into hotspot</li>
                <li>Router connected</li>
            </ul>
        </div>

    </div>



      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Overview</p>
                <h1 class="h3 mb-1">Client Dashboard</h1>
                <p class="text-muted mb-0">Monitor performance, sales, users, and Real-time ISP & Voucher Analytics.</p>
              </div>
            </div>
            <div class="heading-actions"><button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-download" aria-hidden="true"></i> Export</button><button class="btn btn-primary btn-sm" type="button"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i> Create Report</button></div>
          </div>

          <section class="row g-3 mt-1" aria-label="Dashboard metrics">
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-primary">
                <div class="metric-top">
                  <span class="metric-label">Total Vouchers</span>
                  <span class="metric-icon"><i class="bi bi-currency-dollar" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $myVouchers }}</div>
                <div class="metric-meta">
                  <span class="text-success">+12.5%</span>
                  <span>from last month</span>
                </div>
              </article>
            </div>

         

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-success">
                <div class="metric-top">
                  <span class="metric-label">Orders</span>
                  <span class="metric-icon"><i class="bi bi-bag-check" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">1,284</div>
                <div class="metric-meta">
                  <span class="text-success">+8.2%</span>
                  <span>new orders</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-warning">
                <div class="metric-top">
                  <span class="metric-label">Customers</span>
                  <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">8,742</div>
                <div class="metric-meta">
                  <span class="text-success">+5.1%</span>
                  <span>active users</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-danger">
                <div class="metric-top">
                  <span class="metric-label">Routers</span>
                  <span class="metric-icon"><i class="bi bi-life-preserver" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{$routers}}</div>
                <div class="metric-meta">
                  <span class="text-danger">3 urgent</span>
                  <span>need review</span>
                </div>
              </article>
            </div>
          </section>

          <section class="row g-3 mt-1">
            <div class="col-12 col-xl-8">
              <div class="panel">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i><span>Sales Performance</span></h2>
                    <p class="text-muted mb-0">Monthly revenue compared with operational targets.</p>
                  </div>
                  <a class="btn btn-light btn-sm" href="charts.html">View Details</a>
                </div>

                <div class="chart-bars" aria-label="Sales performance chart">
                  <div class="chart-column bar-42"><span></span><small>Jan</small></div>
                  <div class="chart-column bar-58"><span></span><small>Feb</small></div>
                  <div class="chart-column bar-51"><span></span><small>Mar</small></div>
                  <div class="chart-column bar-72"><span></span><small>Apr</small></div>
                  <div class="chart-column bar-66"><span></span><small>May</small></div>
                  <div class="chart-column bar-83"><span></span><small>Jun</small></div>
                </div>
              </div>
            </div>

            <div class="col-12 col-xl-4">
              <div class="panel h-100">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-activity" aria-hidden="true"></i><span>Team Activity</span></h2>
                    <p class="text-muted mb-0">Recent operational updates.</p>
                  </div>
                </div>

                <div class="activity-list">
                  <div class="activity-item"><span class="activity-dot bg-primary"></span><div><p class="mb-1 fw-semibold">New campaign launched</p><p class="text-muted small mb-0">Marketing team published the May offer.</p></div></div>
                  <div class="activity-item"><span class="activity-dot bg-success"></span><div><p class="mb-1 fw-semibold">Payment batch cleared</p><p class="text-muted small mb-0">246 invoices were processed successfully.</p></div></div>
                  <div class="activity-item"><span class="activity-dot bg-warning"></span><div><p class="mb-1 fw-semibold">Support queue rising</p><p class="text-muted small mb-0">Average first response time is 18 minutes.</p></div></div>
                </div>
              </div>
            </div>
          </section>

          <section class="panel mt-3">
            <div class="panel-header">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>Recent Users</span></h2>
                <p class="text-muted mb-0">Latest account activity across the workspace.</p>
              </div>
              <a class="btn btn-outline-secondary btn-sm" href="users.html">Manage Users</a>
            </div>
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead><tr><th scope="col">User</th><th scope="col">Role</th><th scope="col">Team</th><th scope="col">Status</th><th scope="col">Joined</th><th scope="col" class="text-end">Action</th></tr></thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img class="avatar-img avatar-sm" src="../assets/images/avatar/avatar-1.jpg" alt="Sarah Ahmed">
                        <div>
                          <p class="fw-semibold mb-0">Sarah Ahmed</p>
                          <p class="text-muted small mb-0">sarah@example.com</p>
                        </div>
                      </div>
                    </td>
                    <td>Admin</td>
                    <td>Operations</td>
                    <td><span class="badge text-bg-success">Active</span></td>
                    <td>Jan 12, 2026</td>
                    <td class="text-end"><a class="btn btn-light btn-sm" href="user-details.html">View</a></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img class="avatar-img avatar-sm" src="../assets/images/avatar/avatar-2.jpg" alt="Rafi Khan">
                        <div>
                          <p class="fw-semibold mb-0">Rafi Khan</p>
                          <p class="text-muted small mb-0">rafi@example.com</p>
                        </div>
                      </div>
                    </td>
                    <td>Manager</td>
                    <td>Sales</td>
                    <td><span class="badge text-bg-success">Active</span></td>
                    <td>Feb 03, 2026</td>
                    <td class="text-end"><a class="btn btn-light btn-sm" href="user-details.html">View</a></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img class="avatar-img avatar-sm" src="../assets/images/avatar/avatar-3.jpg" alt="Nadia Islam">
                        <div>
                          <p class="fw-semibold mb-0">Nadia Islam</p>
                          <p class="text-muted small mb-0">nadia@example.com</p>
                        </div>
                      </div>
                    </td>
                    <td>Editor</td>
                    <td>Content</td>
                    <td><span class="badge text-bg-warning">Pending</span></td>
                    <td>Mar 18, 2026</td>
                    <td class="text-end"><a class="btn btn-light btn-sm" href="user-details.html">View</a></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img class="avatar-img avatar-sm" src="../assets/images/avatar/avatar-4.jpg" alt="Mina Torres">
                        <div>
                          <p class="fw-semibold mb-0">Mina Torres</p>
                          <p class="text-muted small mb-0">mina@example.com</p>
                        </div>
                      </div>
                    </td>
                    <td>Viewer</td>
                    <td>Finance</td>
                    <td><span class="badge text-bg-secondary">Suspended</span></td>
                    <td>Apr 07, 2026</td>
                    <td class="text-end"><a class="btn btn-light btn-sm" href="user-details.html">View</a></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img class="avatar-img avatar-sm" src="../assets/images/avatar/avatar-5.jpg" alt="Jon Oliver">
                        <div>
                          <p class="fw-semibold mb-0">Jon Oliver</p>
                          <p class="text-muted small mb-0">jon@example.com</p>
                        </div>
                      </div>
                    </td>
                    <td>Analyst</td>
                    <td>Data</td>
                    <td><span class="badge text-bg-success">Active</span></td>
                    <td>Apr 22, 2026</td>
                    <td class="text-end"><a class="btn btn-light btn-sm" href="user-details.html">View</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
        </div>
      </main>

@endsection