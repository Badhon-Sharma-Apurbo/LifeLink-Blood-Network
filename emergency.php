<?php
include 'db_config.php';
$message = ""; 

// ==========================================
// 🔴 SQL TRANSACTION 
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $req_hospital = $_POST['req_hospital'];
    $target_hospital = $_POST['target_hospital'];
    $blood_type = $_POST['blood_type'];
    $units = $_POST['units'];

    // 1. Start Transaction
    $conn->begin_transaction();

    try {
        // 2. Lock the row (FOR UPDATE)
        $check_sql = "SELECT Units_Available FROM Blood_Inventory WHERE Hospital_ID = $target_hospital AND Blood_Type = '$blood_type' FOR UPDATE";
        $result = $conn->query($check_sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            if ($row['Units_Available'] >= $units) {
                // 3. Update Inventory & Log Request
                $conn->query("UPDATE Blood_Inventory SET Units_Available = Units_Available - $units WHERE Hospital_ID = $target_hospital AND Blood_Type = '$blood_type'");
                
                $conn->query("INSERT INTO Blood_Requests (Requesting_Hospital_ID, Target_Hospital_ID, Blood_Type, Units_Requested, Request_Status) VALUES ($req_hospital, $target_hospital, '$blood_type', $units, 'Fulfilled')");
                
                // 4. Commit Changes
                $conn->commit();
                $message = "<div class='mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm'><b>Transaction Successful:</b> $units unit(s) of $blood_type transferred securely.</div>";
            } else {
                throw new Exception("Not enough $blood_type blood in stock at the target hospital.");
            }
        } else {
            throw new Exception("Blood type not found at target hospital inventory.");
        }
    } catch (Exception $e) {
        // 5. Rollback on error
        $conn->rollback();
        $conn->query("INSERT INTO Blood_Requests (Requesting_Hospital_ID, Target_Hospital_ID, Blood_Type, Units_Requested, Request_Status) VALUES ($req_hospital, $target_hospital, '$blood_type', $units, 'Failed')");
        $message = "<div class='mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-sm'><b>Transaction Rolled Back:</b> " . $e->getMessage() . "</div>";
    }
}
?>

<?php include 'header.php'; ?>

<div class="max-w-3xl mx-auto my-16 p-10 bg-white rounded-3xl shadow-2xl border-t-8 border-red-700">
    <h2 class="text-3xl font-black text-gray-900 mb-2 uppercase">Emergency Request Portal</h2>
    <p class="text-gray-500 mb-8 font-medium border-l-4 border-yellow-500 pl-3">This form uses strict Database Concurrency Control (COMMIT/ROLLBACK) to prevent data conflicts.</p>

    <?php echo $message; ?>

    <form method="POST" action="" class="space-y-6 bg-gray-50 p-8 rounded-2xl border border-gray-100">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Requesting Hospital ID</label>
                <input type="number" name="req_hospital" required class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Target Hospital ID</label>
                <input type="number" name="target_hospital" required class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Blood Type Needed</label>
                <select name="blood_type" class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 transition">
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="B+">B+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Units Required</label>
                <input type="number" name="units" required min="1" class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 transition">
            </div>
        </div>

        <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-black py-4 px-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 uppercase tracking-widest text-lg mt-4">
            Execute Secure Transaction
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>
