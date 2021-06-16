# -*- coding:utf-8 -*-

from django.core.management.base import BaseCommand
from ...models import UserInfo
import os

# BaseCommandを継承して作成
class Command(BaseCommand):
    help = ''

    def add_arguments(self, parser):
        """ none """

    def handle(self, *args, **options):
        p = UserInfo(
            id=1,
            username= os.environ("API_USER_NAME"),
            password=os.environ("API_USER_PASSWORD"),
            info=os.environ("API_USER_INFO")
        )
        p.save()

        self.stdout.write(self.style.SUCCESS('API認証ユーザを追加しました。'))