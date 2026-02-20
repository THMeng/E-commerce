@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | List Order
    @endsection
    @section('page-main-title')
      List Order
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Transaction_id</th>
                  <th>fullname</th>
                  <th>phone</th>
                  <th>address</th>
                  <th>total_amount</th>
                  <th>status</th>
                  <th>created_at</th>
                  <th>updated_at</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($order as $value)
                <tr>
                        <td><span class="badge bg-label-primary me-1">{{ $value->id }}</span></td>
                        <td><span class="badge bg-label-warning me-1">{{ $value->transaction_id }}</span></td>
                        <td><span class="badge bg-label-danger me-1">{{ $value->fullname}}</span></td>
                        <td><span class="badge bg-label-warning me-1">{{ $value->phone}}</span></td>
                        <td><span class="badge bg-label-primary me-1">{{ $value->address }}</span></td>
                        <td><span class="badge bg-label-warning me-1">{{ $value->total_amount }} $ </span></td>
                        <td><span class="badge bg-label-danger me-1">{{ $value->status }}</span></td>
                        <td><span class="badge bg-label-warning me-1">{{ $value->created_at }}</span></td>
                        <td><span class="badge bg-label-warning me-1">{{ $value->updated_at }}</span></td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-3">
          <form action="/admin/remove-logo-submit" method="post">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Are you sure to remove this post?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" id="remove-val" name="id">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
        
      <hr class="my-5" />
    </div>
    <!-- / Content -->
  </div>
</div>

@endsection
