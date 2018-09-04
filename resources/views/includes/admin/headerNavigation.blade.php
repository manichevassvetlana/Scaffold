<nav class="navbar page-header">
    <input type="text" id="user-info" style="display: none" value="{{fire_auth()->user()->id}}">
    <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
        <i class="fa fa-bars"></i>
    </a>

    <a class="navbar-brand" href="#">
        <img src="{{ asset('admin/assets/imgs/logo.png') }}" alt="logo">
    </a>

    <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
        <i class="fa fa-bars"></i>
    </a>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a style="border-top: 0;" class="nav-link dropdown-toggle no-after" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="badge badge-pill badge-danger"
                      v-if="notifications.length > 0">@{{ notifications.length }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" style="max-height: 300px; overflow-y: scroll;">
                <div class="dropdown-header">Notifications</div>

                <div class="dropdown-item no-hover" v-for="notification in notifications">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td style="vertical-align: middle"><i :class="notification.icon"></i></td>
                            <td>@{{notification.body}} <br>
                                <a :href="notification.action_url" style="color: lightblue" @click="
                                readNotifications(notification)">@{{notification.action_text}}</a>
                                <button class="btn btn-default btn-sm" style="float: right" @click="
                                readNotifications(notification)">Mark as read</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </li>

        <li class="nav-item d-md-down-none">
            <a href="#">
                <i class="fa fa-envelope-open"></i>
                <span class="badge badge-pill badge-danger">5</span>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <img src="{{ fire_auth()->user()->image !== 0 ? fire_auth()->user()->image : asset('admin/assets/imgs/avatar-1.png') }}"
                     class="avatar avatar-sm" alt="logo">
                <span class="small ml-1 d-md-down-none">{{ Auth::user()->name }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">Account</div>

                <a class="dropdown-item" href="{{url('/profile')}}">
                    <i class="fa fa-user"></i> Profile
                </a>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>