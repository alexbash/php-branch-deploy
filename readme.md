PURPOSE
-----------------------------------------
A deployment script that can accessed from a browser. Once setup it can be used by any web developer no matter what skill level to deploy a branch and test it. Each branch has it's own subdomain, so any branch can be tested by any number of developers or clients at any time.

i.e.  
The branch `branch-name` will appear on domain `http://branch-name.domain.com`  
The branch `branch-name2` will appear on domain `http://branch-name2.domain.com`

If a developer pushes to a branch, a post-receive hook triggers the deploy script which then pulls into the corresponding branch on this dev server.


REQUIREMENTS
-----------------------------------------
The setup requires :

+ Root access to your server
+ A moderate understanding of the command line, apache configuration and user permissions.
+ git-core installation
+ A github.com account and a repository to deploy (obviously)


SETUP
-----------------------------------------
Here are the steps we took to setup this script. There could be differences if installing this script on various versions of linux and windows. So this is for guidance only.

1. Create a root dir `/var/www/vhost/domain`

2. Configure apache vhost :

    <VirtualHost *:80>  
        ServerName domain.com  
        ServerAlias *.domain.com  
        VirtualDocumentRoot /var/www/vhost/domain/%1.0/  
    </VirtualHost>

3. Create a deploy folder `/var/www/vhost/domain/deploy`
The deploy folder is now available on `http://deploy.domain.com`

4. Put the deploy scripts into `/var/www/vhost/domain/deploy`

5. Now setup keys for the apache user 

    $ sudo mkdir /var/www/.ssh
    $ sudo chown -R apache:nobody /var/www/.ssh
    $ sudo -u apache ssh-keygen -t rsa

(for more info on keys see http://help.github.com/mac-set-up-git/)

6. Make sure that git is running
    $ git --version

7. Setup config vars (http://help.github.com/set-your-user-name-email-and-github-token/)

    $ git config --global user.name "Firstname Lastname"
    $ git config --global user.email "your_email@youremail.com"
    $ git config --global github.user username
    $ git config --global github.token 0123456789yourf0123456789token

8. Make sure git is accessible at `/usr/bin/git` (or alter line 15 of deploy/git/Client.php)

9. Disable known_hosts or copy from a user that has ssh'd to github.com
    $ cp /home/user/.ssh/known_hosts /var/www/.ssh/
    $ chown apache:nobody /var/www/.ssh/known_hosts

10. Make root directory writeable by apache
    $ chown -R apache:apache /var/www/vhost/domain

11. Setup post-receive hook (http://help.github.com/post-receive-hooks/)
`http://deploy.domain.com/pull.php`

12. Setup your branches : `http://deploy.domain.com/`


TROUBLESHOOTING
-----------------------------------------
We have not written robust error handling. If there are any issues with the clone the system will hang. http://deploy.domain.com will connect to the API with AJAX. So to view any errors created by the system you can find them in the AJAX response (use firebug)


