<section class="flex items-center flex-col justify-center min-h-screen">

    <?php echo $this->Flash->render(); ?>
    <svg class="w-[100px] h-[100px] text-blue-700 dark:text-blue-500" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd"
            d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-6.616l-2.88 2.592C8.537 20.461 7 19.776 7 18.477V17H5a2 2 0 0 1-2-2V6Zm4 2a1 1 0 0 0 0 2h5a1 1 0 1 0 0-2H7Zm8 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2Zm-8 3a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm5 0a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z"
            clip-rule="evenodd" />
    </svg>
    <h1 class="text-black dark:text-white text-5xl mb-10 font-medium">Register</h1>
    <form class="w-1/4 mx-auto" method="post" action="<?php echo $this->Html->url(array('action' => 'register')); ?>">
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" id="email" name="email"
                class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
            <?php if (!empty($errors['email'])): ?>
            <div class="text-red-500"><?php echo $errors['email'][0]; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" id="name" name="name"
                class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
            <?php if (!empty($errors['name'])): ?>
            <div class="text-red-500"><?php echo $errors['name'][0]; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                password</label>
            <input type="password" id="password" name="password"
                class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
            <?php if (!empty($errors['password'])): ?>
            <div class="text-red-500"><?php echo $errors['password'][0]; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                password</label>
            <input type="password" id="confirm_password" name="confirm_password"
                class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
            <?php if (!empty($errors['confirm_password'])): ?>
            <div class="text-red-500"><?php echo $errors['confirm_password'][0]; ?></div>
            <?php endif; ?>
        </div>
        <div class="flex justify-center">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-10 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
        </div>
    </form>
    <div class="flex items-start mb-5 mt-5">
        <div class="flex items-center h-5">
            <label for="terms" class="text-sm font-medium text-gray-900 dark:text-gray-300">Already have an account? <a
                    href="/cakephp/home/login" class="text-blue-600 hover:underline dark:text-blue-500">Login
                    here</a></label>
        </div>
    </div>
</section>