<div class="modalDropdown" id="userModal">
    <div class="modalTitle">
        <span>Sign in</span><i class="fa fa-times" id="closeUser"></i>
    </div>
    <div class="modalText">
        <form id="signIn" autocomplete="off" novalidate="true">
            <label>Email:</label>
            <input type="text" name="email" />
            <label>Password:</label>
            <input type="password" name="password" id="password" />
            <div id="forgotPassword">Forgot your password?</div>
            <div class="buttonRow">
                <input type="submit" value="Login" />
                <input type="button" value="Register" onclick="window.location.href ='{{url('register')}}'" />
            </div>
        </form>
    </div>
</div>
