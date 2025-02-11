<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2193b0, #6dd5ed);
            text-align: center;
            margin-top: 50px;
        }
        .container {
            width: 120%;
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            background: white;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 6px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .reset-btn {
            background: #dc3545;
            margin-top: 10px;
        }
        .result {
            margin-top: 15px;
            font-weight: bold;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
            font-size: 16px;
            display: none; /* Initially hidden */
        }
        .category {
            font-size: 18px;
            font-weight: bold;
        }
        .category-info {
            font-size: 14px;
            margin-top: 5px;
        }
        /* BMI Color Bar */
        .bmi-scale {
            width: 100%;
            height: 15px;
            margin-top: 20px;
            border-radius: 10px;
            background: linear-gradient(to left, #e74c3c, #f1c40f, #2ecc71);
            transition: background 0.5s ease;
        }

        /* Reference categories section */
        .category-reference {
            margin-top: 30px;
            display: flex;
            justify-content: space-evenly; /* Evenly spaces out the boxes */
            text-align: center;
            gap: 20px; /* Adds space between each category box */
        }

        .category-box {
            padding: 20px;  /* Padding to make the box larger */
            width: 120px;   /* Width of each box */
            border-radius: 5px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 150px;   /* Height of each box */
            font-size: 14px; /* Font size for the text */
            flex-direction: column; /* Stack content vertically */
        }

        .category-image {
            width: 60px; /* Adjust image size */
            height: 100px; /* Adjust image size */
            object-fit: cover; /* Ensure images cover their space */
            margin-bottom: 10px; /* Space between the image and the text */
        }

        .underweight {
            background-color: #3498db;
            color: white;
        }

        .normal {
            background-color: #2ecc71;
            color: white;
        }

        .overweight {
            background-color: #f39c12;
            color: white;
        }

        .obese {
            background-color: #e74c3c;
            color: white;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>BMI Calculator</h2>
    <p>Enter your weight and height to calculate your BMI and see which category you fall into.</p>
    
    <form method="POST">
        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" id="weight" required min="1" step="0.1">
        
        <label for="height">Height (cm):</label>
        <input type="number" name="height" id="height" required min="1" step="1">
        
        <button type="submit">Calculate BMI</button>
        <button type="reset" class="reset-btn">Reset</button>
    </form>

    <div class="bmi-scale" id="bmiScale"></div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $weight = $_POST["weight"];
        $height = $_POST["height"];

        if ($weight > 0 && $height > 0) {
            // Convert height from cm to meters
            $heightInMeters = $height / 100;

            // Calculate BMI
            $bmi = $weight / ($heightInMeters * $heightInMeters);
            $bmi = round($bmi, 1);

            // Determine BMI Category and set bar color
            if ($bmi < 18.5) {
                $category = "Underweight";
                $categoryInfo = "You may need to gain some weight to be in a healthy range.";
                $color = "#3498db"; // Blue for underweight
                $barColor = "linear-gradient(to right, #3498db 25%, #e74c3c 25%)"; // Blue to Red
            } elseif ($bmi < 24.9) {
                $category = "Normal weight";
                $categoryInfo = "You have a healthy weight. Keep up the good work!";
                $color = "#2ecc71"; // Green for normal
                $barColor = "linear-gradient(to right, #2ecc71 50%, #f1c40f 50%)"; // Green to Yellow
            } elseif ($bmi < 29.9) {
                $category = "Overweight";
                $categoryInfo = "You may want to lose a bit of weight for better health.";
                $color = "#f39c12"; // Orange for overweight
                $barColor = "linear-gradient(to right, #f39c12 75%, #e74c3c 75%)"; // Orange to Red
            } else {
                $category = "Obese";
                $categoryInfo = "It's important to lose weight for your health. Consider consulting a doctor.";
                $color = "#e74c3c"; // Red for obese
                $barColor = "linear-gradient(to right, #f39c12 1%, #e74c3c 99%)"; // Full Red
            }

            echo "<div class='result' style='color: $color; border: 2px solid $color; display: block;'>
                    <div class='category'>Your BMI is: $bmi</div>
                    <div class='category-info'>Category: $category</div>
                    <div class='category-info'>$categoryInfo</div>
                  </div>";

            // Output the dynamic color bar
            echo "<script>document.getElementById('bmiScale').style.background = '$barColor';</script>";
        } else {
            echo "<div class='result' style='color: red; border: 2px solid red; display: block;'>Please enter valid positive numbers.</div>";
        }
    }
    ?>

    <!-- Reference Categories Section -->
        <div class="category-reference">
        <div class="category-box underweight">
            <img src="underweight.png" alt="Underweight" class="category-image">
            <div>Underweight</div>
            <div>BMI < 18.5</div>
        </div>
        <div class="category-box normal">
            <img src="normal.png" alt="Normal Weight" class="category-image">
            <div>Normal</div>
            <div>18.5 - 24.9</div>
        </div>
        <div class="category-box overweight">
            <img src="overweight.png" alt="Overweight" class="category-image">
            <div>Overweight</div>
            <div>25 - 29.9</div>
        </div>
        <div class="category-box obese">
            <img src="obese.png" alt="Obese" class="category-image">
            <div>Obese</div>
            <div>BMI > 30</div>
        </div>
    </div>


</div>

</body>
</html>
