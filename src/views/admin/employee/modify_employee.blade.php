@php
    $path = [['title' => $admin['role']['title'] . ' Dashboard']];
@endphp
@extends('Mantis::admin.assets.layout')
@prepend('css')
    <style>
        .images_panel {
            filter: drop-shadow(0 0 20px #00000033);
            position: relative;
            margin-bottom: 85px;
            min-height: 180px;
        }

        .img_con {
            position: relative;
        }

        .banner img {
            aspect-ratio: 16/7;
            min-height: 250px;
            filter: drop-shadow(0 0 20px #00000033);
            border-radius: 10px;
        }

        .banner .img_picker {
            position: absolute;
            right: 0;
            bottom: 0;
            margin: 20px;
            border-radius: 5px;
            background: white;
            font-size: 0.8em;
            padding-right: 10px;
            font-weight: 600;
            cursor: pointer;
            filter: drop-shadow(0 0 20px #00000033);
        }

        .profile {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translate(-50%, 30%);
            border-radius: 50%;
            border: 6px solid white;
            background: var(--gray_200);
        }

        .profile .img_picker {
            position: absolute;
            right: 0;
            bottom: 0;
            border-radius: 5px;
            background: white;
            font-size: 0.8em;
            font-weight: 600;
            cursor: pointer;
            border-radius: 50%;
            margin: 14px;
            box-shadow: 0 0 5px 0 #00000022;
        }

        .profile .img_picker i {
            width: 42px;
            border-radius: 50%;
        }

        .profile img {
            min-width: 250px;
            aspect-ratio: 1;
            height: 250px;
            border-radius: inherit;
        }
    </style>
@endprepend
@section('main')
    <main>
        <x-Mantis::admin.breadcrumb :path="$path"></x-Mantis::admin.breadcrumb>
        <x-Mantis::admin.form>
            <section class="images_panel">
                <div class="img_con banner img_wrap">
                    <x-Mantis::img :img="$emp['banner_image'] ?? ''" class="banner_img preview"></x-Mantis::img>
                    <x-Mantis::img_picker fname="banner_img" class="rflex aic">
                        <i class="icon fa-solid fa-camera"></i> Update
                    </x-Mantis::img_picker>
                </div>
                <div class="img_con profile">
                    <x-Mantis::img :img="$emp['profile_image'] ?? ''" class="profile_img preview"></x-Mantis::img>
                    <x-Mantis::img_picker fname="profile_img">
                        <i class="icon fa-solid fa-camera"></i>
                    </x-Mantis::img_picker>
                </div>
            </section>
            <section class="panel">
                <div class="section_info">
                    <h5 class="section_title">Group Basic Info</h5>
                    <p class="section_desc">Just normal things to create a new group</p>
                </div>
                <fieldset class="cflex">
                    <fieldset>
                        <x-Mantis::field fname="name" label="Full Name">
                            <input type="text" name="name" id="name" placeholder="Name" required
                                value="{{ $emp['name'] ?? '' }}">
                        </x-Mantis::field>
                        <x-Mantis::field fname="gender" label="Gender">
                            <select name="gender" id="gender">
                                <option value="male" @selected(($emp['gender'] ?? '') == 'male')>Male</option>
                                <option value="female" @selected(($emp['gender'] ?? '') == 'female')>Female</option>
                                <option value="transgender" @selected(($emp['gender'] ?? '') == 'transgender')>Transgender</option>
                            </select>
                        </x-Mantis::field>
                    </fieldset>
                    <x-Mantis::field fname="about" label="Employee Description">
                        <textarea name="about" id="about" placeholder="Write something about employee...">{{ $emp['about'] ?? '' }}</textarea>
                    </x-Mantis::field>
                </fieldset>
            </section>
            <section class="panel">
                <div class="section_info">
                    <h5 class="section_title">Contact</h5>
                    <p class="section_desc">Emplyee contact details.</p>
                </div>
                <fieldset class="cflex">
                    <fieldset>
                        <x-Mantis::field fname="contactp" label="Personal Contact">
                            <input type="text" pattern="[0-9]{10}" name="contact[personal]" id="contactp"
                                placeholder="98765xxxxx" required value="{{ $emp['contact']['personal'] ?? '' }}">
                        </x-Mantis::field>
                        <x-Mantis::field fname="contactf" label="Family Contact">
                            <input type="text" pattern="[0-9]{10}" name="contact[family]" id="contactf"
                                placeholder="98765xxxxx" required value="{{ $emp['contact']['family'] ?? '' }}">
                        </x-Mantis::field>
                        <x-Mantis::field fname="contactc" label="Company Contact">
                            <input type="text" pattern="[0-9]{10}" name="contact[company]" id="contactc"
                                placeholder="98765xxxxx" value="{{ $emp['contact']['company'] ?? '' }}">
                        </x-Mantis::field>
                    </fieldset>
                    <fieldset>
                        <x-Mantis::field fname="mailp" label="Personal E-mail">
                            <input type="email" name="email[personal]" id="mailp" placeholder="example@mail.com"
                                required value="{{ $emp['email']['personal'] ?? '' }}">
                        </x-Mantis::field>
                        <x-Mantis::field fname="mailf" label="Family E-mail">
                            <input type="email" name="email[family]" id="mailf" placeholder="example@mail.com"
                                value="{{ $emp['email']['family'] ?? '' }}">
                        </x-Mantis::field>
                        <x-Mantis::field fname="mailc" label="Company E-mail">
                            <input type="email" name="email[company]" id="mailc" placeholder="example@mail.com"
                                value="{{ $emp['email']['company'] ?? '' }}">
                        </x-Mantis::field>
                    </fieldset>
                    <fieldset class="cflex">
                        <x-Mantis::field fname="addc">
                            @slot('label')
                                Employee Address <i class="text info">(Current Living)</i>
                            @endslot
                            <input type="text" name="address[current]" id="addc"
                                placeholder="House No., Landmark, Village/City, District, State(Pin Code)" required
                                value="{{ $emp['address']['current'] ?? '' }}" />
                        </x-Mantis::field>
                        <x-Mantis::field fname="">
                            @slot('label')
                                Employee Address <i class="text info">(Home Town)</i>
                            @endslot
                            <input type="text" name="address[permanent]" id="addp"
                                placeholder="House No., Landmark, Village/City, District, State(Pin Code)"
                                value="{{ $emp['address']['permanent'] ?? '' }}" />
                        </x-Mantis::field>
                    </fieldset>
                </fieldset>
            </section>
            <section class="panel">
                <div class="section_info">
                    <h5 class="section_title">Joining Details</h5>
                    <p class="section_desc">Can only be changed by developers.</p>
                </div>
                <fieldset class="cflex">
                    <fieldset>
                        <x-Mantis::field fname="salary" label="Salary">
                            <input type="text" name="salary" id="salary" placeholder="Salary" required
                                value="{{ $emp['salary'] ?? '' }}">
                        </x-Mantis::field>
                        @if (!isset($employee))
                            <x-Mantis::field fname="joing" label="Joing Date">
                                <input type="date" name="joined" id="joing" required
                                    value="{{ substr($emp['joined_at'] ?? '', 0, strpos($emp['joined_at'] ?? '', 'T')) }}">
                            </x-Mantis::field>
                        @endif
                    </fieldset>
                    <fieldset>
                        <x-Mantis::field fname="role" label="Employee Role">
                            <select name="role" id="role">
                                @foreach ($roles as $role)
                                    <option value="{{ $role['id'] }}" @selected($role['id'] == ($emp['role_id'] ?? 0))>
                                        {{ $role['title'] }}
                                    </option>
                                @endforeach
                            </select>
                        </x-Mantis::field>
                        {{-- <x-Mantis::field fname="dep" label="Employee Department">
                            <select name="dep" id="dep">
                                <option value="">No Department</option>
                                @foreach ($deps as $dep)
                                    <option value="{{ $dep['id'] }}" @selected($dep['id'] == ($emp['department_id'] ?? 0))>
                                        {{ $dep['dep_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </x-Mantis::field> --}}
                        {{-- <x-Mantis::field fname="team" label="Employee Team">
                            <select name="team" id="team">
                                <option value="">No Team</option>
                                @if (isset($emp) && isset($emp['employee_team']))
                                    <option value="{{ $emp['employee_team']['id'] }}" selected>
                                        {{ $emp['employee_team']['team_name'] }}</option>
                                @endif
                            </select>
                        </x-Mantis::field> --}}
                    </fieldset>
                </fieldset>
            </section>
            @if (!isset($emp))
                <section class="panel">
                    <div class="section_info">
                        <h5 class="section_title">Login Credentials</h5>
                        <p class="section_desc">Can only be changed by developers.</p>
                    </div>
                    <fieldset class="cflex">
                        <fieldset>
                            <x-Mantis::field fname="username" label="Username">
                                <input type="username" name="username" id="username" placeholder="Username" required>
                            </x-Mantis::field>
                            <x-Mantis::field fname="password" label="Password">
                                <input type="password" name="password" id="password" placeholder="Password" required>
                            </x-Mantis::field>
                        </fieldset>
                    </fieldset>
                </section>
            @endif
            <fieldset class="cflex">
                <x-Mantis::checkbox fname="can_join_teams" :checked="$emp['can_join_teams'] ?? true" label="Employee can join teams." />
                <x-Mantis::checkbox fname="status" :checked="$emp['status'] ?? true" label="Activate Employee Id" />
            </fieldset>
        </x-Mantis::admin.form>
    </main>
@endsection
