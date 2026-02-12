<form class="profile-card" method="POST">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <h2>Account Information</h2>
    <button type="button" style="width: max-content;" class="btn btn-edit" onclick="window.location.href='?edit=false'">Stop Editing</button>
  </div>
  <hr color="#3498db" style="margin-bottom: 10px;">

  <div class="profile-info">
    <label>First Name</label>
    <input type="text" id="name" name="name" value="<?= $user->getName() ?>">
  </div>

  <div class="profile-info">
    <label>Last Name</label>
    <input type="text" id="lastname" name="lastname" value="<?= $user->getLastname() ?>">
  </div>

  <div class="profile-info">
    <label>Username</label>
    <input type="text" id="username" name="username" value="<?= $user->getUsername() ?>">
  </div>

  <div class="profile-info">
    <label>Email</label>
    <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>">
  </div>

  <br>
  <button class="btn btn-primary" type="submit">Update</button>
</form>