<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Data</title>
  </head>
  <body class="bg-light">
    <div class="container py-5">
      <h3 class="text-center mb-4">Add User</h3>
      <div id="alertMessage" class="alert alert-success d-none" role="alert">
        Data submission successful!
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Add Data</h5>
          <form action="{{ route('user.store') }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="id" class="form-label">ID</label>
              <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Name</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
              <label for="posisi" class="form-label">Position</label>
              <input type="text" class="form-control" id="posisi" name="posisi" required>
            </div>
            <div class="mb-4">
              <label class="form-label mb-2">Role</label>
              <div class="d-flex justify-content-start px-5">
                <div class="form-check me-5">
                  <input class="form-check-input" type="radio" name="role" id="admin" value="Admin" required>
                  <label class="form-check-label" for="admin">Admin</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="role" id="karyawan" value="Karyawan" required>
                  <label class="form-check-label" for="karyawan">Karyawan</label>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="gaji" class="form-label">Base Salary</label>
              <input type="text" class="form-control" id="gaji" name="gaji" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>
          </form>
        </div>
      </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const gajiInput = document.getElementById('gaji');
  
    gajiInput.addEventListener('input', function(e) {
      let angka = this.value.replace(/[^,\d]/g, '').toString();
      let split = angka.split(',');
      let sisa = split[0].length % 3;
      let rupiah = split[0].substr(0, sisa);
      let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
  
      if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
  
      rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
      this.value = rupiah ? 'Rp ' + rupiah : '';
    });
  
    // Saat form dikirim, hilangkan semua karakter non-digit
    document.querySelector('form').addEventListener('submit', function () {
      gajiInput.value = gajiInput.value.replace(/[^0-9]/g, '');
    });
  </script>
</body>
</html>