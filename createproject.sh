 #!/bin/bash         

##first run
#cd  html5-boilerplate
#sudo chmod a+x createproject.sh && ./createproject.sh

##usage
#cd  html5-boilerplate
#./createproject.sh



clear
echo "To create a new html5-boilerplate project, enter a new directory name:"

read name

cd ..

webroot=$PWD

SRC=$webroot"/html5-boilerplate"
DST=$webroot"/"$name

if [ -d "$DST" ]
then
    echo "$DST exists"
else
    #create new project
    mkdir $name

    #sucess message
    echo "Created Directory: $DST"
    
    cd $SRC
    
    #copy to new project directory
    #http://en.wikipedia.org/wiki/Cpio#Copy
    #http://cybertiggyr.com/cpio-howto/
    #http://www.cyberciti.biz/faq/how-do-i-use-cpio-command-under-linux/
    find . -depth -print0 | cpio -0pdmv $DST
    

    #sucess message
    echo "Created Project: $DST"
    
    #move into new project
    cd $DST
    
    #cleanup
    sudo rm -r .git && sudo rm -r createproject.sh
    
    if [ -d "$DST/html5-boilerplate" ]
    then
        sudo rm -r html5-boilerplate
    fi        
      
fi

cd $webroot"/"$name


