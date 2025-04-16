?php
/**
 * Plugin Name: Flour Mill Calculator By Mukesh Ji
 * Description: Stylish calculator for आटा, दारा, सरसों का तेल और आटा+पिसाई.
 * Version: 1.5
 * Author: Mukesh Maurya
 */

function flour_mill_calculator_shortcode() {
    ob_start(); ?>

    <div id="flour-mill-calculator" style="max-width: 550px; padding: 30px; background: linear-gradient(to right, #fff3e0, #ffe0b2); border: 2px solid #ff9800; border-radius: 20px; box-shadow: 0 8px 16px rgba(0,0,0,0.2); font-family: 'Segoe UI', sans-serif;">
        <h2 style="text-align: center; color: #e65100; font-weight: bold; font-size: 26px; margin-bottom: 25px; text-shadow: 1px 1px 2px #ccc;">
            Flour Mill Calculator <span style="color: #d84315;">By Mukesh Ji</span>
        </h2>

        <label for="type" style="font-weight: 600;">प्रकार चुनें:</label><br>
        <select id="type" onchange="toggleInputs()" style="width: 100%; padding: 10px; margin: 8px 0 15px; border-radius: 6px; border: 1px solid #ccc;">
            <option value="aata">आटा</option>
            <option value="dara">दारा</option>
            <option value="tel">सरसों का तेल</option>
            <option value="aata_pisai">आटा + पिसाई</option>
        </select>

        <label for="weight" style="font-weight: 600;">वजन दर्ज करें (किलो में):</label><br>
        <input type="number" id="weight" min="1" style="width: 100%; padding: 10px; margin: 8px 0 15px; border-radius: 6px; border: 1px solid #ccc;" /><br>

        <div id="rate-section" style="display: none;">
            <label for="aata_rate" style="font-weight: 600;">आटा रेट दर्ज करें (₹ प्रति किलो):</label><br>
            <input type="number" id="aata_rate" min="1" value="22" step="0.01" style="width: 100%; padding: 10px; margin: 8px 0 15px; border-radius: 6px; border: 1px solid #ccc;" /><br>
        </div>

        <button onclick="calculateFlour()" style="width: 100%; padding: 12px; background: #ef6c00; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold;">हिसाब लगाएं</button><br><br>

        <div id="result" style="font-weight: bold; color: #388e3c; font-size: 16px;"></div>

        <div style="text-align: center; margin-top: 25px; font-size: 14px;">
            <a href="https://instagram.com/ig_mukesh.maurya" target="_blank" style="color: #e65100; text-decoration: none; font-weight: bold;">@ig_mukesh.maurya</a>
        </div>
    </div>

<script>
    let finalAmount = "";

    function toggleInputs() {
        var type = document.getElementById("type").value;
        var rateSection = document.getElementById("rate-section");

        if (type === "aata_pisai") {
            rateSection.style.display = "block";
        } else {
            rateSection.style.display = "none";
        }
    }

    function calculateFlour() {
        var type = document.getElementById("type").value;
        var weight = parseFloat(document.getElementById("weight").value);
        var result = document.getElementById("result");
        var rate = parseFloat(document.getElementById("aata_rate").value || 22);
        finalAmount = "";

        if (!weight || weight <= 0) {
            result.innerHTML = "कृपया सही वजन दर्ज करें।";
            return;
        }

        let total = 0;

        if (type === "aata") {
            var cut = weight / 40;
            var bacha = weight - cut;
            total = weight * 1.5;
            finalAmount = "कुल कटौती: " + cut.toFixed(2) + " किलो<br>" +
                          "बचा हुआ आटा: " + bacha.toFixed(2) + " किलो<br>" +
                          "राशि: ₹" + total.toFixed(2);
        } else if (type === "dara") {
            total = weight * 1;
            finalAmount = "कुल राशि: ₹" + total.toFixed(2);
        } else if (type === "tel") {
            total = weight * 5;
            finalAmount = "कुल राशि: ₹" + total.toFixed(2);
        } else if (type === "aata_pisai") {
            var jarti = weight / 40;
            var aataAfterJarti = weight - jarti;
            var pisaiCharge = weight * 1.5;
            var cutAata = pisaiCharge / rate;
            var finalAata = aataAfterJarti - cutAata;

            finalAmount += "कुल जर्ती होती है: " + jarti.toFixed(2) + " किलो<br>";
            finalAmount += "जर्ती के बाद बचा आटा: " + aataAfterJarti.toFixed(2) + " किलो<br>";
            finalAmount += "पिसाई शुल्क: ₹" + pisaiCharge.toFixed(2) + "<br>";
            finalAmount += "₹" + pisaiCharge.toFixed(2) + " ÷ ₹" + rate + " = " + cutAata.toFixed(2) + " किलो आटा कटता है<br>";
            finalAmount += "<strong>अंतिम आटा: " + finalAata.toFixed(2) + " किलो</strong><br>";
        }

        result.innerHTML = finalAmount;
    }
</script>

<?php
    return ob_get_clean();
}
