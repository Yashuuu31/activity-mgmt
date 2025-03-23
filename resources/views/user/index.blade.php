@extends('layouts.app')

@section('content')
<!-- Search, Filter, and Sort -->

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex" id="user-filter">
        <input type="text" class="form-control me-2" id="userId" placeholder="User ID">
        <button class="btn btn-primary" id="filterBtn">Filter</button>
    </div>
    <div>
        <button class="btn btn-primary" id="generate-activity">Generate Activity</button>
    </div>
    <div>
        <select class="form-select" id="date-filter">
            <option value="" selected>-- SELECT --</option>
            <option value="TODAY">Today</option>
            <option value="THIS_MONTH">This Month</option>
            <option value="THIS_YEAR">This Year</option>
        </select>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="list-table">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    console.log('User index script');
    $(document).ready(function() {
        function getUsersList()
        {
            let userId = $(document).find('#user-filter #userId').val();
            let dateFilter = $(document).find('#date-filter').val();
            $.ajax({
                url: "",
                type: "GET",
                data: {
                    user_id: userId ?? null,
                    date_filter: dateFilter
                },
                success: function(response) {
                    $(document).find('#list-table tbody').html(response.data);
                }
            });
        }
        
        getUsersList();
        $(document).on('click', '#user-filter #filterBtn', function() {
            getUsersList();
        })

        $(document).on('change', '#date-filter', function() {
            getUsersList();
        })

        $(document).on('click', '#generate-activity', function() {
            $.ajax({
                type: "POST",
                url: "{{ route('generate-activity') }}",
                data:{
                    '_token': "{{ csrf_token() }}"
                },
                success: function (response) {
                    if(response.success) {
                        alert(response.message)
                        getUsersList();
                    }
                }
            });
        });
    });
</script>
@endsection