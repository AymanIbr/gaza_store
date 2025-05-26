

<x-form.input type="text" name="name" :oldval="$role->name" placeholder="Role Name" />


      <fieldset class="border p-3 rounded mt-5">
                <legend class="w-auto px-2">Abilities</legend>

                @foreach (app('abilities') as $ability_code => $ability_name)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ $ability_name }}</label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-check-label">
                                <input type="radio" name="abilities[{{ $ability_code }}]" value="allow" class="form-check-input" @checked(($role_abilities[$ability_code] ?? '') == 'allow') >
                                Allow
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-check-label">
                                <input type="radio" name="abilities[{{ $ability_code }}]" value="deny" class="form-check-input" @checked(($role_abilities[$ability_code] ?? '') == 'deny')>
                                Deny
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="form-check-label">
                                <input type="radio" name="abilities[{{ $ability_code }}]" value="inherit" class="form-check-input" @checked(($role_abilities[$ability_code] ?? '') == 'inherit')>
                                Inherit
                            </label>
                        </div>
                    </div>
                    <hr class="bg-gray-300">
                @endforeach
            </fieldset>
