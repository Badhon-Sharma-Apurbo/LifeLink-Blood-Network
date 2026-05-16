
<?php
include 'db_config.php';
$message = "";

// ==========================================
// 🔴 SQL INSERT QUERY FOR TEACHER TO REVIEW
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['full_name'];
    $blood_type = $_POST['blood_type'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];

    // Simple INSERT query
    $sql = "INSERT INTO Donors (Full_Name, Blood_Type, City_Location, Contact_Number, Eligibility_Status) 
            VALUES ('$name', '$blood_type', '$location', '$contact', 'Available')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded'><b>Success:</b> New volunteer $name registered successfully!</div>";
    } else {
        $message = "<div class='mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded'><b>Error:</b> " . $conn->error . "</div>";
    }
}
?>

<?php include 'header.php'; ?>

<div class="max-w-2xl mx-auto my-16 p-8 bg-white rounded-2xl shadow-2xl border-t-8 border-red-700">
    <h2 class="text-3xl font-black text-gray-900 mb-2 uppercase">Register as a Donor</h2>
    <p class="text-gray-500 mb-6 font-medium border-l-4 border-red-600 pl-3">Fill out this form to join the LifeLink emergency network.</p>

    <?php echo $message; ?>

    <form method="POST" action="" class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Full Name</label>
            <input type="text" name="full_name" required class="mt-2 w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Blood Type</label>
                <select name="blood_type" class="mt-2 w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 transition">
                    <option value="O+">O+</option><option value="O-">O-</option>
                    <option value="A+">A+</option><option value="A-">A-</option>
                    <option value="B+">B+</option><option value="B-">B-</option>
                    <option value="AB+">AB+</option><option value="AB-">AB-</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">City/Location</label>
                <input type="text" name="location" required placeholder="e.g., Dhaka" class="mt-2 w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 transition">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Contact Number</label>
            <input type="text" name="contact" required placeholder="017..." class="mt-2 w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 transition">
        </div>

        <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-black py-4 px-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 uppercase tracking-widest text-lg">
            Join The Network
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>