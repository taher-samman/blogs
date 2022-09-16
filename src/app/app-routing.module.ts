import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './templates/home/home.component';
import { AboutComponent } from './templates/about/about.component';
import { NotFoundComponent } from './templates/not-found/not-found.component';
import { Auth } from './tools/auth/index';
import { LoginComponent } from './templates/login/login.component';
import { NotAuth } from './tools/auth/notauth';
import { RegisterComponent } from './templates/register/register.component';
import { BlogsComponent } from './templates/blogs/blogs.component';
import { Categories } from './tools/categories/index';
import { LayoutComponent } from './templates/layout/layout.component';
const routes: Routes = [
  { path: 'login', component: LoginComponent, canActivate: [NotAuth] },
  { path: 'register', component: RegisterComponent, canActivate: [NotAuth] },
  {
    path: '', component: LayoutComponent, canActivate: [Auth], children: [
      { path: '', component: HomeComponent },
      { path: 'about', component: AboutComponent },
      { path: 'blogs', component: BlogsComponent, canActivate: [Categories] },
    ]
  },
  { path: '**', component: NotFoundComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
