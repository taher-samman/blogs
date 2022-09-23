import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LogoComponent } from './tools/logo/logo.component';
import { NavbarComponent } from './tools/navbar/navbar.component';
import { HomeComponent } from './templates/home/home.component';
import { AboutComponent } from './templates/about/about.component';
import { NotFoundComponent } from './templates/not-found/not-found.component';
import { LoginComponent } from './templates/login/login.component';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ProgressBarComponent } from './tools/progress-bar/progress-bar.component';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { RegisterComponent } from './templates/register/register.component';
import { AddComponent } from './templates/blogs/add/add.component';
import { BlogsComponent } from './templates/blogs/blogs.component';
import { LayoutComponent } from './templates/layout/layout.component';
import { MyBlogsComponent } from './templates/blogs/my-blogs/my-blogs.component';
import { ViewComponent } from './templates/blogs/view/view.component';
import { ShortcutComponent } from './templates/blogs/shortcut/shortcut.component';
import { LoaderComponent } from './tools/loader/loader.component';
import { EditComponent } from './templates/blogs/edit/edit.component';
import { ToolbarComponent } from './tools/toolbar/toolbar.component';
import { LikeComponent } from './tools/toolbar/like/like.component';
import { CommentComponent } from './tools/toolbar/comment/comment.component';
import { ResultComponent } from './tools/toolbar/result/result.component';
import { LoaderToolbarComponent } from './tools/toolbar/loader/loader.component';
import { ProfileComponent } from './templates/blogs/profile/profile.component';

@NgModule({
  declarations: [
    AppComponent,
    LogoComponent,
    NavbarComponent,
    HomeComponent,
    AboutComponent,
    NotFoundComponent,
    LoginComponent,
    ProgressBarComponent,
    RegisterComponent,
    AddComponent,
    BlogsComponent,
    LayoutComponent,
    MyBlogsComponent,
    ViewComponent,
    ShortcutComponent,
    LoaderComponent,
    EditComponent,
    ToolbarComponent,
    LikeComponent,
    CommentComponent,
    ResultComponent,
    LoaderToolbarComponent,
    ProfileComponent
  ],
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    MatProgressBarModule,
    MatSnackBarModule,
    HttpClientModule,
    AppRoutingModule,
    BrowserAnimationsModule
  ],
  providers: [
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }