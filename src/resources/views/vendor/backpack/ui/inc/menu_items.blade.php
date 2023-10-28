{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@canany(['employees.edit', 'employees.see'])
<x-backpack::menu-item title="Employees" icon="la la-question" :link="backpack_url('employee')" />
@endcanany
@canany(['branches.edit', 'branches.see'])
<x-backpack::menu-item title="Branches" icon="la la-question" :link="backpack_url('branch')" />
@endcanany

@canany(['articles.edit', 'articles.see'])
<x-backpack::menu-item title="Articles" icon="la la-question" :link="backpack_url('article')" />
@endcanany

@canany(['categories.edit', 'categories.see'])
<x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
@endcanany

@canany(['roles.edit', 'roles.see', 'permissions.edit', 'permissions.see'])
<x-backpack::menu-dropdown title="Add-ons" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    @canany(['roles.edit', 'roles.see'])
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    @endcanany

    @canany(['permissions.edit', 'permissions.see'])
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
    @endcanany

</x-backpack::menu-dropdown>
@endcanany