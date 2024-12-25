<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white">
<section id="produk" class="bg-white" data-aos="fade-up">
<div class="">
  <div class="mx-auto max-w-2xl px-1 py-16 sm:px-4 sm:py-10 lg:max-w-7xl lg:px-8 pb-8 md:pb-16">
    <div class="flex justify-between items-center">
      <h2 class="text-2xl ml-3 md:text-4xl font-bold text-purple-400">Produk Kami</h2>
      <a href="login" class="mr-3 text-red-500 text-xs md:text-base font-semibold">Lihat semua</a>
    </div>
    <div class="mt-6 mx-3 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-5 xl:gap-x-8">
    @if($produk->isEmpty())
        <p class="col-span-full text-center text-gray-500 text-sm">produknya lagi kosong mas bro</p>
      @else
    @foreach($produk as $item)
    <div class="group relative shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('storage/' . $item->foto_produk) }}" alt="{{ asset($item->nama_produk) }}" class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="login">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $item->nama_produk }}
                </a>
            </h3>
            <div class="flex justify-between items-center">
              <p class="text-sm text-red-400 font-semibold tracking-tight">Rp.  {{ number_format($item->harga_produk, 0, ',', '.') }} </p>
              <button class="text-sm text-white bg-purple-400 px-2 py-2 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 ">
                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      @endif
    </div>
      </div>
    </div>
  </div>
</div>

</section>
</body>
</html>
