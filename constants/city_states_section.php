<?php require '../ShoeSwap/php/ping_test.php'; ?>
<style>
  .custom-select-wrapper {
    position: relative;
  }
  .custom-select-wrapper::after {
    content: '▼';
    position: absolute;
    top: 73%;
    right: 18px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #6c757d;
    font-size: 0.8rem;
  }
  select.form-control {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 2rem; /* reserve space for icon */
    background-color: #fff; /* fix for dark modes if any */
  }
</style>

<div class="mb-3 custom-select-wrapper">
  <label for="state" class="form-label">State</label>
  <select name="state" id="state" class="form-control" required onchange="loadCities()">
    <option value="" disabled selected>Select your state</option>
    <option value="West Bengal">West Bengal</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Delhi">Delhi</option>
  </select>
</div>

<div class="row">
  <div class="mb-3 col-md-6 custom-select-wrapper">
    <label for="city" class="form-label">City</label>
    <select name="city" id="city" class="form-control" required>
      <option value="" disabled selected>Select your city</option>
    </select>
  </div>
  <div class="mb-3 col-md-3">
    <label for="pin" class="form-label">Pin code</label>
    <input type="text" name="pin" class="form-control" id="pin" required maxlength="6">
  </div>
  <div class="mb-3 col-md-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" id="phone" required maxlength="10">
  </div>
</div>

<script>
  const stateCityMap = {
"West Bengal": [
  "Kolkata", "Asansol", "Durgapur", "Siliguri", "Howrah", "Bardhaman", "Malda",
  "Kharagpur", "Berhampore", "Jalpaiguri", "Haldia", "Bankura", "Raiganj",
  "Cooch Behar", "Habra", "Ranaghat", "Krishnanagar", "Purulia", "Balurghat",
  "Alipurduar", "Chinsurah", "Serampore", "Barrackpore", "Bhatpara", "Tamluk",
  "Dankuni", "Uluberia", "Basirhat", "Naihati", "Rishra", "Kanchrapara",
  "Bongaon", "Barasat", "Dum Dum", "New Town", "Salt Lake", "Belgharia",
  "Sodepur", "Midnapore", "Bolpur", "Katwa", "Bishnupur", "Arambagh"
],
"Maharashtra": [
  "Mumbai", "Pune", "Nagpur", "Nashik", "Thane", "Aurangabad", "Solapur",
  "Amravati", "Kolhapur", "Navi Mumbai", "Kalyan-Dombivli", "Vasai-Virar",
  "Sangli", "Jalgaon", "Akola", "Latur", "Ahmednagar", "Dhule", "Chandrapur",
  "Parbhani", "Ichalkaranji", "Jalna", "Bhiwandi", "Panvel", "Satara", 
  "Beed", "Yavatmal", "Nanded", "Wardha", "Ratnagiri"
],
"Karnataka": [
  "Bengaluru", "Mysuru", "Mangaluru", "Hubballi", "Dharwad", "Belagavi",
  "Kalaburagi", "Ballari", "Vijayapura", "Tumakuru", "Bidar", "Shivamogga",
  "Raichur", "Davangere", "Hassan", "Bagalkot", "Udupi", "Kolar", "Chikkamagaluru",
  "Karwar", "Chitradurga", "Mandya", "Hospet", "Ramanagara", "Gadag", "Bijapur"
],
"Tamil Nadu": [
  "Chennai", "Coimbatore", "Madurai", "Salem", "Tiruchirappalli", "Tirunelveli",
  "Erode", "Vellore", "Thoothukudi", "Nagercoil", "Thanjavur", "Dindigul",
  "Cuddalore", "Karur", "Kanchipuram", "Rajapalayam", "Pudukkottai", "Hosur",
  "Nagapattinam", "Sivakasi", "Pollachi", "Namakkal", "Tiruppur", "Ariyalur"
],
"Delhi": [
  "New Delhi", "Dwarka", "Rohini", "Saket", "Karol Bagh", "Lajpat Nagar",
  "Connaught Place", "Chanakyapuri", "Mayur Vihar", "Vasant Kunj",
  "Janakpuri", "South Extension", "Greater Kailash", "Rajouri Garden",
  "Kalkaji", "Pitampura", "Okhla", "Tilak Nagar", "Shahdara", "Nehru Place",
  "Civil Lines", "Preet Vihar", "Punjabi Bagh", "Mehrauli", "Burari"
]
  };

  function loadCities() {
    const stateSelect = document.getElementById("state");
    const citySelect = document.getElementById("city");
    const selectedState = stateSelect.value;

    // Clear previous options
    citySelect.innerHTML = `<option value="" disabled selected>Select your city</option>`;

    if (stateCityMap[selectedState]) {
      stateCityMap[selectedState].forEach(city => {
        const option = document.createElement("option");
        option.value = city;
        option.text = city;
        citySelect.appendChild(option);
      });
    }
  }
</script>
