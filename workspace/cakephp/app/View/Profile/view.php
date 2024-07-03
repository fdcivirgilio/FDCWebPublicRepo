l<section class="flex items-center flex-col justify-center min-h-screen dark:bg-gray-900">
    <h1 class="text-black dark:text-white text-5xl mb-10 font-medium">User profile</h1>
    <div class="col-span-full xl:col-auto w-1/5">
        <div class="bg-white dark:bg-gray-800 shadow-lg shadow-gray-200 dark:shadow-gray-900 rounded-2xl p-4 mb-6 w-full">
            <div class="sm:flex xl:block sm:space-x-4 xl:space-x-0">
                <img class="mb-2 w-24 h-24 rounded-2xl shadow-lg shadow-gray-300 dark:shadow-gray-700 float-left m-5"
                    src="<?php echo $this->Html->url("/" . $users["users"]["profile_image"]); ?>"
                    alt="User's profile image">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100"><?= $users['users']['name'] ?></h2>
                    <ul class="mt-2 space-y-1">
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">

                            Gender: <?= $users['users']['gender'] == 'M' ? 'Male' : 'Female' ?>
                        </li>
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                            
                            Birthdate: <?= date('F j, Y', strtotime($users['users']['birthdate'])) ?>
                        </li>
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                            Joined: <?= date('F j, Y', strtotime($users['users']['created_at'])) ?>
                        </li>
                        
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                            Last login: <?= date('F j, Y', strtotime($users['users']['last_login_time'])) ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mb-4 sm:flex xl:block">
                <div class="sm:flex-1">
                    <address class="text-sm not-italic font-normal text-gray-500 dark:text-gray-400">
                        <div class="mt-4">Email address</div>
                        <a class="text-sm font-medium text-gray-900 dark:text-gray-100"
                            href="mailto:webmaster@flowbite.com"><?= $users['users']['email'] ?> </a>
                        <div class="mt-4">Hobby</div>
                        <div class="mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            <?= $users['users']['hobby'] ?>
                        </div>
                        
                    </address>
                </div>
            </div>
        </div>
    </div>
</section>
