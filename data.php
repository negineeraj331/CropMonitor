<?php
// Regional farm data based on location (keeping farm names and crops only)
$regionalData = [
    'north' => [
        'name' => 'Northern Valley Farm',
        'crops' => ['Wheat', 'Barley', 'Potatoes']
    ],
    'south' => [
        'name' => 'Southern Plains Farm',
        'crops' => ['Cotton', 'Corn', 'Soybeans']
    ],
    'east' => [
        'name' => 'Eastern Highlands Farm',
        'crops' => ['Rice', 'Tea', 'Vegetables']
    ],
    'west' => [
        'name' => 'Western Desert Farm',
        'crops' => ['Dates', 'Olives', 'Grapes']
    ]
];

// Common farm tasks (same for all regions)
$farmTasks = [
    ['id' => 1, 'task' => 'Water Fields', 'status' => 'pending', 'priority' => 'high'],
    ['id' => 2, 'task' => 'Apply Fertilizer', 'status' => 'completed', 'priority' => 'medium'],
    ['id' => 3, 'task' => 'Harvest Crops', 'status' => 'pending', 'priority' => 'high'],
    ['id' => 4, 'task' => 'Check Irrigation', 'status' => 'in-progress', 'priority' => 'low']
];

// Weather advisory data
$weatherAdvisory = [
    'north' => [
        'icon' => 'cloud-rain',
        'condition' => 'Rain expected tomorrow',
        'advice' => 'Consider delaying irrigation',
        'color' => 'blue'
    ],
    'south' => [
        'icon' => 'sun',
        'condition' => 'Heat wave warning',
        'advice' => 'Increase water supply to crops',
        'color' => 'yellow'
    ],
    'east' => [
        'icon' => 'cloud',
        'condition' => 'Mild weather expected',
        'advice' => 'Ideal conditions for growth',
        'color' => 'gray'
    ],
    'west' => [
        'icon' => 'temperature-high',
        'condition' => 'Extreme heat warning',
        'advice' => 'Use shade nets for sensitive crops',
        'color' => 'red'
    ]
];

// Function to get status color
function getStatusColor($status) {
    $statusColors = [
        'normal' => 'bg-green-100 text-green-800',
        'optimal' => 'bg-green-100 text-green-800',
        'completed' => 'bg-green-100 text-green-800',
        'high' => 'bg-yellow-100 text-yellow-800',
        'low' => 'bg-yellow-100 text-yellow-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'alert' => 'bg-red-100 text-red-800',
        'warning' => 'bg-orange-100 text-orange-800',
        'in-progress' => 'bg-blue-100 text-blue-800',
        'info' => 'bg-blue-100 text-blue-800'
    ];
    return $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
}

// Function to get trend icon
function getTrendIcon($trend) {
    $trendIcons = ['up' => '↑', 'down' => '↓', 'steady' => '→'];
    return $trendIcons[$trend] ?? '';
}

// Farm news bulletin
$farmNews = [
    'north' => [
        ['title' => 'New Irrigation System', 'date' => '2025-04-03', 'type' => 'update', 
         'content' => 'Minor signs of rust detected in sector 3, preventive measures advised'],
        ['title' => 'Harvest Schedule', 'date' => '2025-04-05', 'type' => 'info',
         'content' => 'Early harvest planned for next week due to favorable weather conditions']
    ],
    'south' => [
        ['title' => 'Heat Wave Warning', 'date' => '2025-04-03', 'type' => 'alert',
         'content' => 'Temperatures expected to rise above 40°C, extra irrigation scheduled'],
        ['title' => 'Cotton Market Update', 'date' => '2025-04-04', 'type' => 'info',
         'content' => 'Cotton prices trending upward, consider storage options']
    ],
    'east' => [
        ['title' => 'Tea Processing Unit', 'date' => '2025-04-03', 'type' => 'update',
         'content' => 'New processing unit operational, increasing daily capacity by 40%'],
        ['title' => 'Rainfall Forecast', 'date' => '2025-04-04', 'type' => 'info',
         'content' => 'Heavy rainfall expected next week, harvest schedule adjusted']
    ],
    'west' => [
        ['title' => 'Drought Measures', 'date' => '2025-04-03', 'type' => 'alert',
         'content' => 'Water conservation protocols in effect due to continued dry spell'],
        ['title' => 'New Solar Panels', 'date' => '2025-04-04', 'type' => 'update',
         'content' => 'Solar power system expansion completed, reducing energy costs']
    ]
];
?>