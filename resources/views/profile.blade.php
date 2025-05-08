<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel x Autz.org</title>
  <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <meta name="theme-color" content="#712cf9">
  <link href="/app.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
  <main class="form-signin w-100 m-auto">
    <form action="/login" method="post">
      @csrf
      <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Welcome back, {{ $user->name }}!</h1>
      <p class="text-muted small my-3">
        Here is your data
      </p>
      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="demo@example.com" value="{{$user->email}}" disabled>
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="demo@example.com" value="{{$user->phone ?? '-' }}" disabled>
        <label for="floatingInput">Phone number</label>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="demo@example.com" value="{{$user->address ?? '-' }}" disabled>
        <label for="floatingInput">Address</label>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="demo@example.com" value="{{$user->dob ?? '-' }}" disabled>
        <label for="floatingInput">Date of Birth</label>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="demo@example.com" value="{{$user->gender ?? '-' }}" disabled>
        <label for="floatingInput">Gender</label>
      </div>
      <a href="/logout" class=" mt-3 btn btn-outline-danger w-100 py-2" type="submit">
        Logout
      </a>
      <p class="mt-5 mb-3 text-body-secondary">&copy; Laravel x Autz.org</p>
    </form>
  </main>
  <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
