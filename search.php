<?php 
include 'db_config.php';
include 'header.php';

$search_results = null;

if (isset($_GET['blood_type'])) {
    $bt = $_GET['blood_type'];
    $loc = $_GET['location'];
    
    // 🔴 SQL : Using LIKE operator for flexible searching
    $sql = "SELECT * FROM Donors WHERE Blood_Type = '$bt' AND City_Location LIKE '%$loc%' AND Eligibility_Status = 'Available'";
    $search_results = $conn->query($sql);
}
?>

<div class="max-w-7xl mx-auto p-12">
    <div class="bg-white p-8 rounded-2xl shadow-xl mb-12">
        <h2 class="text-2xl font-bold mb-6">Find Available Donors</h2>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <select name="blood_type" class="p-3 border rounded-lg focus:ring-2 focus:ring-red-500">
                <option value="O+">O+</option><option value="O-">O-</option>
                <option value="A+">A+</option><option value="B+">B+</option>
                <option value="AB+">AB+</option><option value="AB-">AB-</option>
            </select>
            <input type="text" name="location" placeholder="City (e.g. Dhaka)" class="p-3 border rounded-lg">
            <button type="submit" class="bg-red-700 text-white font-bold rounded-lg hover:bg-red-800">SEARCH NOW</button>
        </form>
    </div>

    <?php if ($search_results): ?>
        <h3 class="text-xl font-bold mb-4">Results Found: <?php echo $search_results->num_rows; ?></h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php while($row = $search_results->fetch_assoc()): ?>
                <div class="bg-white p-6 border-l-8 border-red-600 rounded shadow hover:shadow-md transition">
                    <h4 class="text-xl font-bold"><?php echo $row['Full_Name']; ?></h4>
                    <p class="text-gray-500">Location: <?php echo $row['City_Location']; ?></p>
                    <p class="text-red-700 font-black mt-2 text-2xl"><?php echo $row['Blood_Type']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
