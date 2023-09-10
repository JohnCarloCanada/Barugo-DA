<x-app>
    <x-slot:title>
        User Dashboard
    </x-slot:title>

    <x-sidebar type="dashboard"/>
    
    <section>Main Content</section>
    
    @vite('resources/js/sideBarMenu.js')
</x-app>