<x-app>
    <x-slot:title>
        User | Location
    </x-slot:title>

    <x-sidebar type="farm locations"/>

    <section class="w-full min-h-screen p-5">
        <x-admin.titleCard title="Farmer`s Location" slogan="Their livelihood's urban location ensured access to a diverse market and numerous customers for their fresh produce." />
        <div class="w-[100%,900px] h-[500px] mx-auto overflow-hidden bg-white">
            <div id="map" class="w-[900px,100%] min-h-screen"></div>
        </div>
    </section>
</x-app>


<script>
    const locations = {{Js::From($locations)}}
    
    let map = L.map('map').setView([11.3002, 124.7630], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    locations.forEach(location => {
        var marker = L.marker([parseFloat(location.Lat), parseFloat(location.Lon)]).addTo(map);
        marker.bindPopup(`${location.Lot_No}-${location.Area_Type} Area`).openPopup();
    });
</script>