<?php
include 'db_config.php';
include 'header.php';

// 1. SQL QUERY: Count total registered donors
$donor_count_query = "SELECT COUNT(*) AS total_donors FROM donors";
$donor_result = $conn->query($donor_count_query);
$total_donors = ($donor_result) ? $donor_result->fetch_assoc()['total_donors'] : 0;

// 2. SQL QUERY: Sum total blood units available across all hospitals
$blood_sum_query = "SELECT SUM(Units_Available) AS total_units FROM blood_inventory";
$blood_result = $conn->query($blood_sum_query);
$total_units = ($blood_result) ? $blood_result->fetch_assoc()['total_units'] : 0;

// 3. SQL QUERY: Fetch recent requests using INNER JOIN
$requests_query = "SELECT r.*, 
                          h1.Hospital_Name AS RequestingHospital, 
                          h2.Hospital_Name AS TargetHospital 
                   FROM blood_requests r
                   INNER JOIN hospitals h1 ON r.Requesting_Hospital_ID = h1.Hospital_ID
                   INNER JOIN hospitals h2 ON r.Target_Hospital_ID = h2.Hospital_ID
                   ORDER BY r.Request_ID DESC LIMIT 5";
$requests_result = $conn->query($requests_query);

// 4. NEW SQL QUERY: Fetch ALL donor records to show when the card is clicked
$donors_list_query = "SELECT * FROM donors ORDER BY Donor_ID DESC";
$donors_list_result = $conn->query($donors_list_query);
?>

<div class="max-w-7xl mx-auto p-6 my-8">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-800 tracking-tight uppercase">📊 System Analytics Dashboard</h2>
        <p class="text-gray-500 text-sm">Real-time relational database diagnostics. Click on analytics cards to drill down into logs.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        
        <div onclick="toggleDonorTable()" class="bg-white p-6 rounded-2xl shadow-md border-t-4 border-red-600 flex justify-between items-center cursor-pointer hover:shadow-xl hover:border-red-700 transition-all transform hover:-translate-y-1 select-none group">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-red-600 transition-colors">Total Registered Volunteers</p>
                <h3 class="text-4xl font-black text-gray-800 mt-1"><?php echo htmlspecialchars($total_donors); ?></h3>
                <span class="text-xs text-red-500 font-medium underline inline-block mt-2">Click to view all donors ↓</span>
            </div>
            <div class="bg-red-50 p-4 rounded-full text-2xl group-hover:bg-red-100 transition-colors">👥</div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md border-t-4 border-red-600 flex justify-between items-center select-none">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Safe Units Available</p>
                <h3 class="text-4xl font-black text-gray-800 mt-1"><?php echo htmlspecialchars($total_units ? $total_units : 0); ?> Bags</h3>
                <span class="text-xs text-gray-400 inline-block mt-2">Aggregated from hospital assets</span>
            </div>
            <div class="bg-red-50 p-4 rounded-full text-2xl">🩸</div>
        </div>
    </div>

    <div id="donorTableContainer" class="hidden bg-white rounded-2xl shadow-md overflow-hidden border border-red-200 mb-12 transition-all duration-300">
        <div class="p-6 bg-red-700 border-b border-red-800 flex justify-between items-center">
            <h3 class="font-bold text-white uppercase text-sm tracking-wider">📋 Complete Volunteer Database Registry (SELECT * VIEW)</h3>
            <button onclick="toggleDonorTable()" class="text-white hover:text-red-200 font-bold text-sm bg-red-800 px-3 py-1 rounded-lg">Close ×</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                        <th class="p-4">Donor ID</th>
                        <th class="p-4">Full Name</th>
                        <th class="p-4 text-center">Blood Type</th>
                        <th class="p-4">City Location</th>
                        <th class="p-4">Contact Number</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php if ($donors_list_result && $donors_list_result->num_rows > 0): ?>
                        <?php while($donor = $donors_list_result->fetch_assoc()): ?>
                            <tr class="hover:bg-red-50/50 transition">
                                <td class="p-4 font-mono text-xs text-gray-400">#<?php echo htmlspecialchars($donor['Donor_ID']); ?></td>
                                <td class="p-4 font-bold text-gray-900"><?php echo htmlspecialchars($donor['Full_Name']); ?></td>
                                <td class="p-4 text-center font-bold text-red-600"><span class="bg-red-50 px-2.5 py-1 rounded-md"><?php echo htmlspecialchars($donor['Blood_Type']); ?></span></td>
                                <td class="p-4 text-gray-600"><?php echo htmlspecialchars($donor['City_Location']); ?></td>
                                <td class="p-4 font-mono text-sm"><?php echo htmlspecialchars($donor['Contact_Number']); ?></td>
                                <td class="p-4 text-center">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full <?php echo $donor['Eligibility_Status'] === 'Available' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                        <?php echo htmlspecialchars($donor['Eligibility_Status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 italic">No registered donors found in the database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
        <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-700 uppercase text-sm tracking-wider">⚡ Recent Emergency Transactions (INNER JOIN View)</h3>
            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full">Live Logs</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                        <th class="p-4">Req. Hospital</th>
                        <th class="p-4">Target Hospital</th>
                        <th class="p-4 text-center">Blood Type</th>
                        <th class="p-4 text-center">Units</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php if ($requests_result && $requests_result->num_rows > 0): ?>
                        <?php while($row = $requests_result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-semibold text-gray-900"><?php echo htmlspecialchars($row['RequestingHospital']); ?></td>
                                <td class="p-4 text-gray-600"><?php echo htmlspecialchars($row['TargetHospital']); ?></td>
                                <td class="p-4 text-center font-bold text-red-600"><span class="bg-red-50 px-2 py-1 rounded"><?php echo htmlspecialchars($row['Blood_Type']); ?></span></td>
                                <td class="p-4 text-center font-medium"><?php echo htmlspecialchars($row['Units_Requested']); ?></td>
                                <td class="p-4 text-center">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                        <?php echo htmlspecialchars($row['Request_Status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 italic">No emergency transactions logged yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function toggleDonorTable() {
    const tableContainer = document.getElementById('donorTableContainer');
    
    // Toggle the hidden class
    tableContainer.classList.toggle('hidden');
    
    // If table is opened, smoothly scroll down to focus on it
    if (!tableContainer.classList.contains('hidden')) {
        tableContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>

<?php include 'footer.php'; ?>