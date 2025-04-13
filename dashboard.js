document.addEventListener('DOMContentLoaded', function() {
    // Check if region is already set in URL
    const urlParams = new URLSearchParams(window.location.search);
    
    if (!urlParams.has('region')) {
        // Ask for location if no region is set
        getLocation();
    } else {
        // Fallback to default coordinates if no location
        fetchWeatherData(51.5074, -0.1278); // Default to London coordinates
    }
});

// New function to fetch weather data from OpenWeather API
async function fetchWeatherData(lat, lng) {
    try {
        const response = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&units=metric&appid=e0d8c9af35dd8e4ca834a29fbcb18b2b`);
        const data = await response.json();
        
        if (data.main) {
            updateWeatherUI({
                temperature: data.main.temp,
                humidity: data.main.humidity,
                pressure: data.main.pressure,
                windSpeed: data.wind.speed,
                weatherCondition: data.weather[0].main
            });
        }
    } catch (error) {
        console.error('Error fetching weather data:', error);
    }
}

// New function to update UI with weather data
function updateWeatherUI(weatherData) {
    // Update temperature
    const tempElement = document.querySelector('[data-sensor="temperature"]');
    if (tempElement && tempElement.querySelector('.value') && tempElement.querySelector('.status')) {
        tempElement.querySelector('.value').textContent = Math.round(weatherData.temperature);
        tempElement.querySelector('.status').textContent = getWeatherStatus(weatherData.temperature, 'temp');
        tempElement.querySelector('.status').className = 'status ' + getStatusClass(getWeatherStatus(weatherData.temperature, 'temp'));
    }
    
    // Update humidity
    const humidityElement = document.querySelector('[data-sensor="humidity"]');
    if (humidityElement && humidityElement.querySelector('.value') && humidityElement.querySelector('.status')) {
        humidityElement.querySelector('.value').textContent = weatherData.humidity;
        humidityElement.querySelector('.status').textContent = getWeatherStatus(weatherData.humidity, 'humidity');
        humidityElement.querySelector('.status').className = 'status ' + getStatusClass(getWeatherStatus(weatherData.humidity, 'humidity'));
    }
    
    // Update wind speed
    const windElement = document.querySelector('[data-sensor="wind"]');
    if (windElement && windElement.querySelector('.value') && windElement.querySelector('.status')) {
        windElement.querySelector('.value').textContent = weatherData.windSpeed.toFixed(1);
        windElement.querySelector('.status').textContent = getWeatherStatus(weatherData.windSpeed, 'wind');
        windElement.querySelector('.status').className = 'status ' + getStatusClass(getWeatherStatus(weatherData.windSpeed, 'wind'));
    }
    
    // Update weather condition
    const weatherElement = document.querySelector('[data-sensor="weather"]');
    if (weatherElement && weatherElement.querySelector('.value')) {
        weatherElement.querySelector('.value').textContent = weatherData.weatherCondition;
    }
    
    // Generate and display insights
    const insights = generateInsights(weatherData);
    displayInsights(insights);
}

// Helper function to determine status based on value
function getWeatherStatus(value, type) {
    if (type === 'temp') {
        if (value < 10) return 'Low';
        if (value > 30) return 'High';
        return 'Normal';
    } else if (type === 'humidity') {
        if (value < 30) return 'Low';
        if (value > 70) return 'High';
        return 'Normal';
    } else if (type === 'wind') {
        if (value > 10) return 'High';
        return 'Normal';
    }
    return '';
}

// Helper function to get status CSS class
function getStatusClass(status) {
    switch(status.toLowerCase()) {
        case 'high': return 'bg-red-500 text-red-800';
        case 'low': return 'bg-yellow-300 text-yellow-800';
        default: return 'bg-green-100 text-green-800';
    }
}






// Generate actionable insights from weather data
function generateInsights(weatherData) {
    const insights = [];
    const region = document.getElementById('farmLocation').textContent.toLowerCase();
    
    // Temperature insights
    if (weatherData.temperature < 10) {
        insights.push({
            icon: 'temperature-low',
            color: 'blue',
            title: 'Cold Weather Alert',
            advice: 'Consider protecting sensitive crops with covers or moving potted plants indoors.'
        });
    } else if (weatherData.temperature > 30) {
        insights.push({
            icon: 'temperature-high',
            color: 'red',
            title: 'Heat Warning',
            advice: 'Increase irrigation frequency and consider shading for delicate plants.'
        });
    }
    
    // Humidity insights
    if (weatherData.humidity < 40) {
        insights.push({
            icon: 'tint',
            color: 'yellow',
            title: 'Low Humidity',
            advice: 'Plants may need more frequent watering. Monitor soil moisture closely.'
        });
    } else if (weatherData.humidity > 75) {
        insights.push({
            icon: 'tint',
            color: 'blue',
            title: 'High Humidity',
            advice: 'Watch for fungal diseases. Ensure proper ventilation and spacing between plants.'
        });
    }
    
    // Wind insights
    if (weatherData.windSpeed > 10) {
        insights.push({
            icon: 'wind',
            color: 'orange',
            title: 'High Winds',
            advice: 'Secure loose items and protect young plants. Consider delaying spraying applications.'
        });
    }
    
    // Region-specific insights
    if (region.includes('north')) {
        insights.push({
            icon: 'snowflake',
            color: 'blue',
            title: 'Northern Region Tip',
            advice: 'Monitor overnight temperatures for potential frost warnings.'
        });
    } else if (region.includes('south')) {
        insights.push({
            icon: 'sun',
            color: 'orange',
            title: 'Southern Region Tip',
            advice: 'Schedule irrigation for early morning to reduce evaporation losses.'
        });
    }
    
    return insights;
}

// Display insights in UI
function displayInsights(insights) {
    const container = document.getElementById('insightsContainer');
    
    if (insights.length === 0) {
        container.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                <p class="mt-2 text-gray-600">No special actions needed based on current conditions</p>
            </div>
        `;
        return;
    }
    
    let html = '<div class="space-y-4">';
    insights.forEach(insight => {
        html += `
            <div class="bg-${insight.color}-50 p-4 rounded-lg border-l-4 border-${insight.color}-500">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-${insight.icon} text-${insight.color}-500 mt-1"></i>
                    <div>
                        <h3 class="font-medium text-gray-800">${insight.title}</h3>
                        <p class="text-sm text-gray-600 mt-1">${insight.advice}</p>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    container.innerHTML = html;
}

async function getLocation() {
    const locationStatus = document.getElementById('locationStatus');
    const locationDetails = document.getElementById('locationDetails');
    const addressElement = document.getElementById('address');
    const accuracyElement = document.getElementById('accuracy');
    
    locationStatus.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Detecting location...';
    locationDetails.classList.add('hidden');
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            async function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = Math.round(position.coords.accuracy);
                
                // Update accuracy immediately
                accuracyElement.textContent = accuracy;
                
                // Fetch weather data for this location
                fetchWeatherData(lat, lng);
                
                // Determine region based on latitude
                let region;
                if (lat > 35) {
                    region = 'north';
                } else if (lat < -35) {
                    region = 'south';
                } else if (lng > 0) {
                    region = 'east';
                } else {
                    region = 'west';
                }
                
                // Reverse geocoding to get address
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
                    const data = await response.json();

                    if (data && data.display_name) {
                        addressElement.textContent = data.display_name;
                        locationDetails.classList.remove('hidden');
                        locationStatus.textContent = 'Location detected';
                        
                        // Update URL with region
                        window.history.replaceState(null, null, `?region=${region}`);
                    } else {
                        addressElement.textContent = 'Address not found';
                        locationDetails.classList.remove('hidden');
                        locationStatus.textContent = 'Location detected';
                        window.history.replaceState(null, null, `?region=${region}`);
                    }
                } catch (apiError) {
                    console.error('API Error:', apiError);
                    addressElement.textContent = 'Error fetching address';
                    locationDetails.classList.remove('hidden');
                    locationStatus.textContent = 'Location detected';
                    window.history.replaceState(null, null, `?region=${region}`);
                }
            },
            function(error) {
                // Fallback if location access is denied
                console.error("Error getting location:", error);
                locationStatus.textContent = "Using default region (Northern Farm)";
                
                // Set default region after a delay
                setTimeout(() => {
                    window.location.href = '?region=north';
                }, 1500);
            }
        );
    } else {
        // Geolocation not supported
        locationStatus.textContent = "Geolocation not supported. Using default region.";
        setTimeout(() => {
            window.location.href = '?region=north';
        }, 1500);
    }
}

// Handle task completion
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    const taskText = checkbox.nextElementSibling;
    
    // Set initial state
    if (checkbox.checked) {
        taskText.classList.add('line-through', 'text-gray-400');
    }
    
    // Handle checkbox changes
    checkbox.addEventListener('change', function() {
        taskText.classList.toggle('line-through');
        taskText.classList.toggle('text-gray-400');
    });
});