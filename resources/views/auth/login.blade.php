<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Security System</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Font: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #10b981 100%);
    }
    .login-image {
      background-image: url('https://eduenforce.com/pluginfile.php/1/local_mb2builder/images/LawFront.png');
      background-size: cover;
      background-position: center;
    }
    .card-blur {
      backdrop-filter: blur(6px);
      background-color: rgba(255, 255, 255, 0.85);
    }
  </style>
</head>
<body class="min-h-screen flex justify-center items-center p-4">
  <div class="flex w-full max-w-4xl rounded-xl shadow-2xl overflow-hidden">
    <!-- Login Form Section -->
    <div class="w-full md:w-1/2 p-8 bg-white card-blur">
      <div class="flex justify-center mb-4">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
          <i class="bi bi-shield-lock text-blue-600 text-2xl"></i>
        </div>
      </div>
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-1">Security Portal</h2>
      <h4 class="text-lg text-center text-gray-600 mb-6">Secure Authentication Required</h4>

      @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4 text-sm">
          <i class="bi bi-exclamation-circle mr-2"></i>
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-4">
          <div class="flex justify-between items-center text-gray-600 font-medium text-sm mb-1">
            <label for="login" class="block">Email or Employee ID</label>
          </div>
          <div class="relative">
            <i class="bi bi-person absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input
              type="text"
              name="login"
              class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              id="login"
              placeholder="Enter email or employee ID"
              required
            />
          </div>
        </div>

        <div class="mb-3">
          <div class="flex justify-between items-center text-gray-600 font-medium text-sm mb-1">
            <label for="password" class="block">Password</label>
            <span id="togglePassword" class="flex items-center gap-1 text-gray-500 text-xs cursor-pointer">
              <i class="bi bi-eye-slash" id="eyeIcon"></i> <span id="toggleText">Hide</span>
            </span>
          </div>
          <div class="relative">
            <i class="bi bi-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input
              type="password"
              name="password"
              class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              id="password"
              placeholder="Enter your password"
              required
            />
          </div>
        </div>

        <div class="flex items-center justify-between mt-4 mb-6">
          <div class="flex items-center">
            <input 
              type="checkbox" 
              id="rememberMe" 
              name="remember" 
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            >
            <label for="rememberMe" class="ml-2 block text-sm text-gray-700">
              Remember me
            </label>
          </div>
          <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>

        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white font-medium py-2.5 px-4 rounded-full transition-all duration-300 shadow-md hover:shadow-lg">
          <i class="bi bi-box-arrow-in-right mr-2"></i> Login
        </button>
      </form>

      <div class="relative flex items-center my-6">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="flex-shrink mx-4 text-gray-500 text-sm">OR</span>
        <div class="flex-grow border-t border-gray-300"></div>
      </div>

      <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-full py-2.5 px-4 font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-300 mb-6">
    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5" />
    Continue with Google
</a>


       
      
      <!-- SLTMOBITEL Logo -->
      <div class="flex justify-center mt-4">
        <img
          src="https://i.postimg.cc/QCkgQS5p/SLTMobitel-Logo-svg.png"
          alt="SLTMobitel Logo"
          class="h-10"
        />
      </div>
    </div>

    <!-- Image Section -->
    <div class="hidden md:block md:w-1/2 login-image relative">
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/30 flex items-end justify-center pb-12">
        <div class="text-center p-8 text-white">
          <h2 class="text-3xl font-bold mb-4">Welcome Back,</h2>
          <p class="text-lg mb-6">Secure login for authorized personnel only</p>
         
        </div>
      </div>
    </div>
  </div>

  <!-- Password Toggle Script -->
  <script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");
    const toggleText = document.getElementById("toggleText");

    togglePassword.addEventListener("click", function () {
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
      eyeIcon.className =
        type === "password" ? "bi bi-eye-slash" : "bi bi-eye";
      toggleText.textContent =
        type === "password" ? "Hide" : "Show";
    });
  </script>
</body>
</html>