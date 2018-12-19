

import java.io.IOException;
import java.nio.file.FileSystems;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardWatchEventKinds;
import java.nio.file.WatchEvent;
import java.nio.file.WatchKey;
import java.nio.file.WatchService;

public class Ouvir {

	public static void main(String[] args) throws IOException,
			InterruptedException {

		//Path faxFolder = Paths.get("//javari/IQC_F2/Jose_Alberto");
		Path faxFolder = Paths.get("./fax");
		WatchService watchService = FileSystems.getDefault().newWatchService();
		WatchEvent.Kind<?>[] events = { StandardWatchEventKinds.ENTRY_CREATE,
        StandardWatchEventKinds.ENTRY_DELETE,
        StandardWatchEventKinds.ENTRY_MODIFY };
		faxFolder.register(watchService, events, com.sun.nio.file.ExtendedWatchEventModifier.FILE_TREE);

		boolean valid = true;
		do {
			WatchKey watchKey = watchService.take();

			for (WatchEvent event : watchKey.pollEvents()) {
				WatchEvent.Kind kind = event.kind();
				if (StandardWatchEventKinds.ENTRY_CREATE.equals(event.kind())) {
					String fileName = event.context().toString();
					if(!(fileName.substring(fileName.length()-3).equals("TMP") || fileName.substring(fileName.length()-3).equals("tmp"))){
						System.out.println("File Created:" + fileName);
					}
					
				}
			}
			valid = watchKey.reset();

		} while (valid);

	}
}