#!/bin/bash

REPOSITORY_URL=https://github.com/sokorahen-szk/warzone-aoe.git
FILE_NAME=`basename ${0%}`
DEPLOY_TYPE=`basename ${1}`
ENV=`basename ${2}`
BRANCH_NAME=main
APP_DIR=warzone-aoe
APP_SRC=backend

function pre_deploy {
    echo "start pre_deploy"

    if [ ! -d ~/$APP_DIR ]; then
        echo "create tmp"
        mkdir tmp
    else
        echo "delete tmp files"
        rm -fr ./tmp/*
    fi

    if [ ! -d ~/$APP_DIR ]; then
        echo "git clone"
        git clone $REPOSITORY_URL
    else
        cd ~/$APP_DIR
        git checkout $BRANCH_NAME
        echo "git rebase"
        git pull --rebase origin $BRANCH_NAME
    fi

    echo "end pre_deploy"
    return 0
}

function deploy {
    echo "rm ~/www/*|.htaccess"
    rm -fr ~/www/*
    rm -f ~/www/.htaccess
    echo "copy ~/tmp/public ~/$APP_DIR/$APP_SRC/public"
    cp -fr ~/tmp/public/* ~/www
    cp -f ~/tmp/public/.htaccess ~/www

    echo ~/$APP_DIR/$APP_SRC > ~/www/.path

    if [ ! -f ~/$APP_DIR/$APP_SRC/.env ]; then
        echo "copy ~/.env_$ENV to ~/$APP_DIR/$APP_SRC/.env"
        cp -f ~/.env_$ENV ~/$APP_DIR/$APP_SRC/.env

        cd ~/$APP_DIR/$APP_SRC
        echo "artisan key, jwt generate"
        php artisan key:generate
        php artisan jwt:secret
    fi

    if [ ! -d ~/$APP_DIR/$APP_SRC/vender ]; then
        cd ~/$APP_DIR/$APP_SRC
        echo "composer install"
        composer install
    fi

    if [ ! -d ~/$APP_DIR/$APP_SRC/public/storage ]; then
        cd ~/$APP_DIR/$APP_SRC
        echo "storage link"
        php artisan storage:link
    fi

    cd ~/www
    echo "ln storage link"
    ln -s ~/$APP_DIR/$APP_SRC/public/storage storage

    return 0
}

function post_deploy {
    cd ~/$APP_DIR/$APP_SRC
    echo "clear task config, cache, route"
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear

    return 0
}

#############################################
# main
#############################################
echo "start $FILE_NAME"

if [ "pre_deploy" = "$DEPLOY_TYPE" ]; then
    pre_deploy
elif [ "deploy" = "$DEPLOY_TYPE" ]; then
    deploy
    post_deploy
fi

echo "end $FILE_NAME"