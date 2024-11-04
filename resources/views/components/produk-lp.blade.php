<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white">
<section id="produk" class="bg-white" data-aos="zoom-in">
<div class="">
  <div class="mx-auto max-w-2xl px-1 py-16 sm:px-4 sm:py-10 lg:max-w-7xl lg:px-8 pb-8 md:pb-16">
    <div class="flex justify-between items-center">
      <h2 class="text-2xl ml-3 md:text-4xl font-bold text-purple-400">Produk Kami</h2>
      <a href="login" class="mr-3 text-red-500 text-xs md:text-base font-semibold">Lihat semua</a>
    </div>
    <div class="mt-6 mx-3 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-5 xl:gap-x-8">
    <div class="group relative shadow-sm rounded-lg bg-white">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
        <img src="{{ asset('assets/shop.jpg') }}" alt="foto produknya bro" class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
    </div>
    <div class="ml-2">
        <div>
            <h3 class="text-sm text-gray-700">
                <a href="login">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    Teh pucuk
                </a>
            </h3>
            <div class="flex justify-between items-center">
              <p class="text-sm text-red-400 font-semibold tracking-tight">Rp. 4000</p>
              <button class="text-sm text-white bg-purple-400 px-2 py-2 rounded-md tracking-wide">beli</button>
            </div>
          </div>
        </div>
      </div>


      <!-- card 2 -->
      <div class="group relative shadow-sm rounded-lg bg-white">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
          <img src="{{ asset('assets/shop.jpg') }}" alt="foto produknya bro" class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
        </div>
        <div class="ml-2">
          <div>
            <h3 class="text-sm text-gray-700">
              <a href="login">
                <span aria-hidden="true" class="absolute inset-0"></span>
                chocolatos
              </a>
            </h3>
            <div class="flex justify-between items-center">
              <p class="text-sm text-red-400 font-semibold tracking-tight">Rp. 4000</p>
              <button class="text-sm text-white bg-purple-400 px-2 py-2 rounded-md tracking-wide">beli</button>
            </div>
          </div>
        </div>
      </div>

      <!-- card 3 -->
      <div class="group relative shadow-sm rounded-lg bg-white">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
          <img src="{{ asset('assets/shop.jpg') }}" alt="foto produknya bro" class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
        </div>
        <div class="ml-2">
          <div>
            <h3 class="text-sm text-gray-700">
              <a href="login">
                <span aria-hidden="true" class="absolute inset-0"></span>
                Chiki
              </a>
            </h3>
            <div class="flex justify-between items-center">
              <p class="text-sm text-red-400 font-semibold tracking-tight">Rp. 4000</p>
              <button class="text-sm text-white bg-purple-400 px-2 py-2 rounded-md tracking-wide">beli</button>
            </div>
          </div>
        </div>
      </div>

      <!-- card 4 -->
      <div class="group relative shadow-sm rounded-lg bg-white">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
          <img src="{{ asset('assets/shop.jpg') }}" alt="foto produknya bro" class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
        </div>
        <div class="ml-2">
          <div>
            <h3 class="text-sm text-gray-700">
              <a href="login">
                <span aria-hidden="true" class="absolute inset-0"></span>
                Sosis
              </a>
            </h3>
            <div class="flex justify-between items-center">
              <p class="text-sm text-red-400 font-semibold tracking-tight">Rp. 4000</p>
              <button class="text-sm text-white bg-purple-400 px-2 py-2 rounded-md tracking-wide">beli</button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- card 5 -->
      <div class="group relative shadow-sm rounded-lg bg-white">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75 lg:h-60 flex justify-center items-center">
          <img src="{{ asset('assets/shop.jpg') }}" alt="foto produknya bro" class="max-w-[80%] max-h-[80%] object-cover object-center mt-2">
        </div>
        <div class="ml-2">
          <div>
            <h3 class="text-sm text-gray-700">
              <a href="login">
                <span aria-hidden="true" class="absolute inset-0"></span>
                Milo
              </a>
            </h3>
            <div class="flex justify-between items-center">
              <p class="text-sm text-red-400 font-semibold tracking-tight">Rp. 4000</p>
              <button class="text-sm text-white bg-purple-400 px-2 py-2 rounded-md tracking-wide">beli</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    
 

      </div>
    </div>
  </div>
</div>
</div>

</section>
</body>
</html>
