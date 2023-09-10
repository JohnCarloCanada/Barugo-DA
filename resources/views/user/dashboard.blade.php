<x-app>
    <x-slot:title>
        User Dashboard
    </x-slot:title>

    <h1>Dashboard</h1>

    <form action="{{ route('logout')}}" method="post">
        @csrf

        <div>
            <input type="submit" value="logout">
        </div>
    </form>
</x-app>