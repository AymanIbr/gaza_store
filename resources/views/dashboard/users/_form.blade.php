<div class="mb-3">
    <x-form.input type="text" name="name" :oldval="$user->name" placeholder="Name" />
</div>

<div class="mb-3">
    <x-form.input type="text" name="email" :oldval="$user->email" placeholder="Email" />
</div>


<div class="mb-3">
    <x-form.check label="Roles" name="roles[]" :oldval="$user_role" :options="$roles" />
</div>
