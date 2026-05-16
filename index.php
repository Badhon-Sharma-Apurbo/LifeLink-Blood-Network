<?php include 'header.php'; ?>

<div class="relative h-[600px] flex items-center justify-center overflow-hidden">
    <img src="LIFELINK HPIC.png" class="absolute inset-0 w-full h-full object-cover brightness-50" alt="Blood Donation">
    
    <div class="relative text-center px-6">
        <h2 class="text-white text-5xl md:text-7xl font-black mb-4 uppercase tracking-tighter">Every Drop Counts</h2>
        <p class="text-red-100 text-lg md:text-2xl max-w-3xl mx-auto font-light italic mb-8">
            "The blood you donate gives someone another chance at life. Connect instantly with regional hospitals and save lives through our secure matching network."
        </p>
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="search.php" class="bg-red-600 text-white px-10 py-4 rounded font-bold text-lg hover:bg-red-700 shadow-xl transition">FIND DONORS NOW</a>
            <a href="add_donor.php" class="bg-white text-gray-900 px-10 py-4 rounded font-bold text-lg hover:bg-gray-100 shadow-xl transition">BECOME A VOLUNTEER</a>
        </div>
    </div>
</div>

<section class="max-w-7xl mx-auto py-20 px-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
        <div class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-red-600">
            <h4 class="text-4xl font-black text-gray-800 mb-2">100%</h4>
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Data Integrity</p>
        </div>
        <div class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-red-600">
            <h4 class="text-4xl font-black text-gray-800 mb-2">Real-Time</h4>
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Hospital Sync</p>
        </div>
        <div class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-red-600">
            <h4 class="text-4xl font-black text-gray-800 mb-2">Secure</h4>
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest">Transactions</p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>