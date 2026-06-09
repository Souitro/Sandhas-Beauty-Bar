<section id="home" class="gradient-bg text-white section-padding">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Beautiful Nails & <br />
                    Exquisite Scents
                </h1>
                <p class="text-xl mb-8 text-pink-100">
                    Discover premium nail tech services and luxury perfumes that express your unique style and personality.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="openModal()"
                    style="
                    padding:8px;
                    color:white;
                    border-radius:6px;
                    background-color: #963dcdff;
                    ">
                        Book Appointment
                    </button>
                    <button style="
                    padding:8px;
                    color:white;
                    border-radius:6px;
                    background-color:#8b5cf6;
                    "
                    onclick="document.getElementById('products').scrollIntoView({ behavior: 'smooth' })"
                        class="btn-secondary border-white text-white hover:bg-white hover:text-[var(--primary-color)]">
                        Shop Now
                    </button>
                </div><br>
                <p style="font-size:30px;color: #0a06ffff"><b style="color: #ffffff">Developed By</b>: <a href="https://souitro-innovation-tech-solutions.netlify.app/">Souitro Innovation Tech Solutions</a></p>
            </div>

            <div class="relative">
                <div class="w-full h-96 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <img 
                        src="components/img/nail.jpg"
                        alt="Beautiful nail art and perfumes"
                        class="w-full h-full object-cover rounded-2xl"
                    />
                </div>

                <!-- Floating Cards -->
                <div class="absolute -top-4 -left-4 bg-white rounded-lg p-4 shadow-lg">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-[var(--primary-color)] rounded-full flex items-center justify-center">
                            <div class="icon-star text-sm text-white"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Premium Quality</p>
                            <p class="text-xs text-gray-600">5-star rated</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-4 -right-4 bg-white rounded-lg p-4 shadow-lg">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-[var(--accent-color)] rounded-full flex items-center justify-center">
                            <div class="icon-heart text-sm text-white"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">1000+ Happy Clients</p>
                            <p class="text-xs text-gray-600">And counting</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>