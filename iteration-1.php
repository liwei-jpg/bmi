<!DOCTYPE html>
<html lang="en">

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




</div>

</body>
</html>
