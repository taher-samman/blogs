import { EditComponent } from './templates/blogs/edit/edit.component';
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
import { Categories } from './tools/blogs/categories';
import { Blogs } from './tools/blogs/blogs';
import { LayoutComponent } from './templates/layout/layout.component';
import { MyBlogsComponent } from './templates/blogs/my-blogs/my-blogs.component';
import { AddComponent } from './templates/blogs/add/add.component';
import { ViewComponent } from './templates/blogs/view/view.component';
const routes: Routes = [
  { path: 'login', component: LoginComponent, canActivate: [NotAuth] },
  { path: 'register', component: RegisterComponent, canActivate: [NotAuth] },
  {
    path: '', component: LayoutComponent, canActivate: [Auth], children: [
      { path: '', component: HomeComponent },
      { path: 'about', component: AboutComponent },
      { path: 'view/:id', component: ViewComponent },
      {
        path: 'blogs', component: BlogsComponent, children: [
          { path: '', component: MyBlogsComponent },
          { path: 'add', component: AddComponent},
          { path: 'view/:id', component: ViewComponent },
          { path: 'edit/:id', component: EditComponent },
        ]
      },
    ]
  },
  { path: '**', component: NotFoundComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
