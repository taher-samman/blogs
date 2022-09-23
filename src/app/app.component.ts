import { LoaderService } from './services/loader/loader.service';
import { Component } from '@angular/core';
import { ApisService } from './services/apis/apis.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.less']
})
export class AppComponent {
  title = 'blogs';
  constructor(private apis: ApisService,private loader: LoaderService) {
    this.loader.show.next(false);
  }
}
