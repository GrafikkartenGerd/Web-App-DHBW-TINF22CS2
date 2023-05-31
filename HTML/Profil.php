<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css">
</head>
<body style="width: 100%; overflow: scroll;">
    <form style="width: 50%; left: 25%; position: relative;">
        <div class="border-bottom border-2 pb-4">
            <h2 class="text-base font-semibold">Profile</h2>
            <p class="mt-2 text-sm text-muted">This information will be displayed publicly so be careful what you share.</p>
      
            <div class="mt-4 row">
              <div class="col-md-8">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="TobiasRuhland">
              </div>
            </div>
      
            <div class="mt-4">
              <label for="about" class="form-label">About</label>
              <textarea id="about" name="about" rows="3" class="form-control"></textarea>
              <p class="mt-2 text-sm text-muted">Write a few sentences about yourself.</p>
            </div>
      
            <div class="mt-4">
              <label for="photo" class="form-label">Photo</label>
              <div class="d-flex align-items-center gap-3">
                <svg class="h-12 w-12 text-muted" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                </svg>
                <button type="button" class="btn btn-outline-secondary">Change</button>
              </div>
            </div>
      
            <div class="mt-4">
              <label for="cover-photo" class="form-label">Cover photo</label>
              <div class="mt-2 border rounded-lg border-dashed border-muted p-4 text-center">
                <svg class="h-12 w-12 text-muted" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M4 13V7c0-1.105.895-2 2-2h12c1.105 0 2 .895 2 2v6c0 1.105-.895 2-2 2H6c-1.105 0-2-.895-2-2zm18 7.9c0 .83-.674 1.5-1.5 1.5H3.5C2.67 22.4 2 21.73 2 20.9V19h20v1.9zM21.8 17H2.2C1.01 17 1 16.32 1 16V8c0-.32.01-1 .2-1H2v1.27c.34-.17.71-.27 1-.27h16c.29 0 .66.1 1 .27V7h.8c.19 0 .2.68.2 1v8c0 .32-.01 1.01-.2 1.01zm-19.6-.39l3.55-1.58L6.75 14l3.55-1.57L14.1 14l3.55-1.57L20.45 14l3.55-1.57V8H2v8.61z" />
                </svg>
                <p class="mt-2 text-sm text-muted">Upload a high-resolution photo that represents you.</p>
                <button type="button" class="btn btn-outline-secondary">Upload photo</button>
              </div>
            </div>
      
            <div class="mt-4 row">
              <div class="col-md-6">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Tobias">
              </div>
              <div class="col-md-6">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Ruhland">
              </div>
            </div>
      
            <div class="mt-4">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="tobias@example.com">
            </div>
      
            <div class="mt-4">
              <label for="country" class="form-label">Country</label>
              <select name="country" id="country" class="form-select">
                <option value="germany">Germany</option>
                <option value="usa">USA</option>
                <option value="france">France</option>
              </select>
            </div>
      
            <div class="mt-4 row">
              <div class="col-md-6">
                <label for="street" class="form-label">Street</label>
                <input type="text" name="street" id="street" class="form-control" placeholder="123 Example Street">
              </div>
              <div class="col-md-6">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Berlin">
              </div>
            </div>
      
            <div class="mt-4 row">
              <div class="col-md-6">
                <label for="zip" class="form-label">ZIP Code</label>
                <input type="text" name="zip" id="zip" class="form-control" placeholder="12345">
              </div>
              <div class="col-md-6">
                <label for="state" class="form-label">State</label>
                <input type="text" name="state" id="state" class="form-control" placeholder="Brandenburg">
              </div>
            </div>
      
            <div class="mt-4">
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="button" class="btn btn-link">Cancel</button>
            </div>
          </div>
        </form>
</body>
</html>
