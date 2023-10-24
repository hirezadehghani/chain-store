{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<x-backpack::menu-item title="Employees" icon="la la-question" :link="backpack_url('employee')" />
<x-backpack::menu-item title="Branches" icon="la la-question" :link="backpack_url('branch')" />
<x-backpack::menu-item title="Articles" icon="la la-question" :link="backpack_url('article')" />