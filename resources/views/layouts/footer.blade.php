<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About Section -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">Paradise Of Indonesia</h3>
                <p class="text-gray-400">Discover the beauty of Indonesia with our curated travel experiences. From pristine beaches to ancient temples, we bring you the best of Indonesian culture and nature.</p>
            </div>

            <!-- Quick Links -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('destinations.index') }}" class="text-gray-400 hover:text-white">Destinations</a></li>
                    <li><a href="{{ route('tours.index') }}" class="text-gray-400 hover:text-white">Tours</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>

            <!-- Popular Destinations -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">Popular Destinations</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Bali</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Raja Ampat</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Yogyakarta</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Komodo Island</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-span-1">
                <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-2">
                    <li class="text-gray-400"><i class="fas fa-phone mr-2"></i>WhatsApp+62 8158 5333 325</li>
                    <li class="text-gray-400"><i class="fas fa-envelope mr-2"></i>cs@paradiseofindonesia.com</li>
                    <li class="text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i>Alamat : Jalan Gading Karya 2 No 1 Kel. Gading Kecamatan Tambaksari kota Surabaya  Jawa Timur</li>
                </ul>
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-8 border-t border-gray-800 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} Paradise Of Indonesia. All rights reserved.</p>
        </div>
    </div>
</footer>