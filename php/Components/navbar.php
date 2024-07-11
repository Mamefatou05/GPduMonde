<header class="py-4 shadow-sm bg-white w-full">
        <div class="container flex items-center justify-between">
            <a href="index.html">
                <img src="assets/images/logo.svg" alt="Logo" class="w-32">
            </a>

            <div class="w-full max-w-xl relative flex">
                <span class="absolute left-4 top-3 text-lg text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" id="search"
                    class="w-full border border-primary border-r-0 pl-12 py-3 pr-3 rounded-l-md focus:outline-none hidden md:flex"
                    placeholder="search">
                <button class="border text-center py-3 border-primary text-gray-800 px-8 rounded-r-md hover:bg-transparent hover:text-primary transition hidden md:flex">Search</button>
            </div>

            <div class="flex items-center space-x-4 ">
            <div class="flex space-x-4 items-center">
                    <a class="hidden md:block h-6 cursor-pointer hover:scale-125 transition-transform duration-200 ease-out" href="#">
                        <i class="fa-solid fa-house fa-lg"></i>
                    </a>
                    <a class="h-6 cursor-pointer hover:scale-125 transition-transform duration-200 ease-out" onclick="my_modal_4.showModal()" href="#">
                        <i class="fa-regular fa-square-plus  fa-lg"></i>
                    </a>
                    <a class="h-6 cursor-pointer hover:scale-125 transition-transform duration-200 ease-out" href="#">
                        <i class="fa-solid fa-gear fa-lg" style="color: #ff0000;"></i>
                    </a>
                    <img 
                    class="h-10 rounded-full cursor-pointer hover:scale-125 transition-transform duration-200 ease-out"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT1caeT2foAPJnPRJlyX9L-0oag9U1W75Jiiu0oNA81Bg&s" 
                    alt="user-image"/>
                </div>
            </div>
        </div>
    </header>
<nav class="bg-gray-800">
        <div class="container flex">
        

            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a  href="index.php?page=dashboard" class="text-gray-200 hover:text-white transition">Dashboard</a>
                    <a href="#" class="text-gray-200 hover:text-white transition">About us</a>
                    <a href="index.php?page=contact" class="text-gray-200 hover:text-white transition">Contact us</a>
                </div>
                <a href="pages/login.html" class="text-gray-200 hover:text-white transition">Login</a>
            </div>
        </div>
    </nav>
    
