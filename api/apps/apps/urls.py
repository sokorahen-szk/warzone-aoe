"""apps URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path

from api.views import Auth, DefaultSkill, CalcSkill, TeamDivisionPattern, DataConversion

urlpatterns = [

    # JWT token取得
    path('v2/post/token', Auth.as_view()),

    # 認証後 API
    path('v2/get/default_skill', DefaultSkill.as_view()),
    path('v2/post/calc_skill', CalcSkill.as_view()),
    path('v2/post/team_division_pattern', TeamDivisionPattern.as_view()),
    path('v2/post/data_conversion', DataConversion.as_view()),

]
