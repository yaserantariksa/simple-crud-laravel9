<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CRUD Laravel 9</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 shadow rounded">
          <div class="card-body">
            <a href="{{ route('posts.create') }}" class="btn btn-md btn-success mb-3">TAMBAH POST</a>
            <table class="table table-bordered">
              <thead>
                <tr>
                <th scope="col" class="text-center">GAMBAR</th>
                <th scope="col" class="text-center">JUDUL</th>
                <th scope="col" class="text-center">CONTENT</th>
                <th style="width: 15%" class="text-center">AKSI</th>
              </thead>
              <tbody>
                @forelse ($posts as $post)
                    <tr>
                    <td class="text-center">
                      <img src="{{ asset('storage/posts/'.$post->image) }}" alt="post image" class="rounded" width="100px">
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{!! $post->content !!}</td>
                    <td class="text-center">
                      <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda Yakin ?');">
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>                      
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                      </form>
                    </td>
                @empty
                    <div class="alert alert-danger" type="submit">
                      Data Post belum tersedia
                    </div>
                @endforelse
              </tbody>
            </table>
            {{ $posts->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    //message with toastr
    @if (session()->has('success'))
      toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif (session()->has('error'))
      toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif
  </script>

</body>
</html>