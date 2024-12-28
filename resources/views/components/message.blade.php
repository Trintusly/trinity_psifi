<div>
    <!-- Display success message if present in session -->
    @if (session()->has('success'))
        <div class="notification is-success mb-2">
            <i class="fas fa-smile"></i> {{ session()->get('success') }}
        </div>
    @endif

    <!-- Display error messages if there are any -->
    @if ($errors->any())
        <div class="notification is-danger mb-2">
            <i class="fas fa-exclamation-triangle"></i> 
            <b>Correct the following error(s) before continuing!</b>

            <!-- Loop through each error and display it -->
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
</div>
