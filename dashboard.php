<?php 
include 'data.php';

// Default to Northern farm if no region is selected
$region = $_GET['region'] ?? 'north';
$farmData = $regionalData[$region] ?? $regionalData['north'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Farming Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
<header class="bg-gradient-to-b from-green-700 to-green-600 text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-start md:items-center space-y-2 md:space-y-0">
    <div class="flex items-center">
  <img src="i4.jpg" alt="" class="rounded-full mr-2 size-16">
  <a href="#" class="text-3xl font-bold text-green-100">CropMonitor</a>
</div>

        <div class="flex flex-col items-end space-y-1">
            <button onclick="getLocation()" class="bg-green-600 hover:bg-green-800 px-4 py-2 rounded-md transition flex items-center">
                <i class="fas fa-location-arrow mr-2"></i>Detect My Location
            </button>
            <div id="locationInfo" class="text-right">
                <div id="locationStatus" class="text-sm"></div>
                <div id="locationDetails" class="hidden">
                    <div class="font-medium text-sm">
                        <span id="address">Location not detected</span>
                    </div>
                    <div class="text-sm">
                        Accuracy: <span id="accuracy"></span> meters
                    </div>
                </div>
                <div id="farmLocation" class="text-sm mt-1">
                    <?php echo $farmData['name']; ?>
                </div>
            </div>
        </div>
    </div>
</header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-6">
            <!-- Farm Info -->
            <section class="mb-6 bg-gradient-to-t from-green-500 to-green-600 rounded-lg shadow-md p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800"><?php echo $farmData['name']; ?></h2>
                        <p class="text-gray-600 mt-1">
                            Current Region: <span class="font-medium capitalize"><?php echo $region; ?></span>
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <h3 class="text-lg font-medium text-gray-800">Main Crops</h3>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <?php foreach ($farmData['crops'] as $crop): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                    <?php echo $crop; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sensor Grid -->
            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Farm Environment Monitoring</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Temperature -->
                    <div class="bg-orange-200 rounded-lg shadow-md p-6 border-l-4 border-orange-500 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110" data-sensor="temperature">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 font-medium">Temperature</h3>
                                <p class="text-3xl font-bold mt-2">
                                    <span class="value">--</span><span class="text-lg text-gray-500">°C</span>
                                </p>
                            </div>
                            <span class="status px-3 py-1 bg-orange-200 rounded-xl text-xs font-medium">
                                Loading...
                            </span>
                        </div>
                    </div>

                    <!-- Humidity -->
                    <div class="bg-yellow-100 rounded-lg shadow-md p-6 border-l-4 border-yellow-500 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110" data-sensor="humidity">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 font-medium">Humidity</h3>
                                <p class="text-3xl font-bold mt-2">
                                    <span class="value">--</span><span class="text-lg text-gray-500">%</span>
                                </p>
                            </div>
                            <span class="status px-3 py-1 rounded-full text-xs font-medium">
                                Loading...
                            </span>
                        </div>
                    </div>

                    <!-- Wind Speed -->
                    <div class="bg-cyan-100 rounded-lg shadow-md p-6 border-l-4 border-cyan-500 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110" data-sensor="wind">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 font-medium">Wind Speed</h3>
                                <p class="text-3xl font-bold mt-2">
                                    <span class="value">--</span><span class="text-lg text-gray-500">m/s</span>
                                </p>
                            </div>
                            <span class="status px-3 py-1 rounded-full text-xs font-medium">
                                Loading...
                            </span>
                        </div>
                    </div>

                    <!-- Weather Condition -->
                    <div class="bg-blue-200 rounded-lg shadow-md p-6 border-l-4 border-blue-500 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110" data-sensor="weather">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 font-medium">Weather</h3>
                                <p class="text-3xl font-bold mt-2">
                                    <span class="value">--</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tasks and News -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 ">
                <!-- Tasks Section -->
                <section class="lg:col-span-2 ">
                    <div class=" rounded-lg bg-gradient-to-b from-green-300 to-green-200 shadow-md overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Farm Tasks</h2>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <?php foreach ($farmTasks as $task): ?>
                                <div class="px-6 py-3 flex items-center space-x-4">
                                    <input type="checkbox" class="h-5 w-5 text-green-600" <?php echo $task['status'] === 'completed' ? 'checked' : ''; ?>>
                                    <span class="flex-grow text-gray-800"><?php echo $task['task']; ?></span>
                                    <span class="text-sm px-2 py-1 rounded <?php 
                                        echo $task['priority'] === 'high' ? 'bg-red-100' : 
                                             ($task['priority'] === 'medium' ? 'bg-yellow-100' : 'bg-blue-100'); 
                                    ?>">
                                        <?php echo ucfirst($task['priority']); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- News Bulletin Section -->
                    <div class="bg-gradient-to-b from-purple-300 to-purple-200 rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800">News Bulletin</h2>
                            <div class="text-sm text-gray-500"><?php echo date('F j, Y'); ?></div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <?php foreach ($farmNews[$region] as $news): ?>
                                <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <i class="fas fa-<?php 
                                                echo $news['type'] === 'alert' ? 'exclamation-circle text-red-500' : 
                                                    ($news['type'] === 'update' ? 'sync text-green-500' : 'info-circle text-blue-500'); 
                                            ?> text-lg"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <h3 class="font-medium text-gray-900 mb-1"><?php echo $news['title']; ?></h3>
                                            <p class="text-gray-600 text-sm mb-2"><?php echo $news['content']; ?></p>
                                            <div class="text-xs text-gray-400">
                                                <?php 
                                                    $date = new DateTime($news['date']);
                                                    echo $date->format('M j, Y');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
                    <!-- Weather Section -->
                <!-- Weather Section -->
                <section class="lg:col-span-1">
                    <div class="bg-gradient-to-b from-cyan-200 to-cyan-100 rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Weather Advisory</h2>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <i class="fas fa-<?php echo $weatherAdvisory[$region]['icon']; ?> text-4xl text-<?php echo $weatherAdvisory[$region]['color']; ?>-500 mb-3" data-weather-icon></i>
                                <p class="font-medium text-lg mb-2" data-weather-condition><?php echo $weatherAdvisory[$region]['condition']; ?></p>
                                <p class="text-sm text-gray-600" data-weather-advice><?php echo $weatherAdvisory[$region]['advice']; ?></p>
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <p class="text-xs text-gray-500">Last updated: <?php echo date('g:i A'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Actionable Insights -->
                <section class="lg:col-span-1 mt-6">
                    <div class="bg-gradient-to-b from-violet-200 to-violet-100 rounded-lg shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Actionable Insights</h2>
                        </div>
                        <div class="p-6">
                            <div id="insightsContainer">
                                <div class="text-center py-4">
                                    <i class="fas fa-spinner fa-spin text-gray-400 text-2xl"></i>
                                    <p class="mt-2 text-gray-500">Analyzing weather data...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <!-- Footer -->
  <footer class="bg-gray-800 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-gray-300 text-center">
      <p>&copy; 2025 CropMonitor. All rights reserved.</p>
      <div class="mt-3 space-x-4">
        <a href="#" class="hover:text-white transition duration-300" >Privacy Policy</a>
        <a href="#" class="hover:text-white transition duration-300" >Terms of Service</a>
        <a href="#contact" class="hover:text-white transition duration-300" >Contact</a>
      </div>
      <div class="mt-4 text-sm">
        <p>Made with ❤️ for sustainable farming</p>
      </div>
    </div>
  </footer>

    <script src="dashboard.js"></script>
</body>
</html>