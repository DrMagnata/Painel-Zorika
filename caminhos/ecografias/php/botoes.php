<?php foreach ($historico as $row): ?>
                <tr>
                    <td><?= $row['tipo'] ?></td>
                    <td><?= $row['nome'] ?></td>
                    <td><?= date('d/m/y H:i:s', strtotime($row['datahora'])) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="chamarNovamente(<?= $row['id'] ?>)">Chamar Novamente</button>
                        <button class="btn btn-success btn-sm" onclick="chegou(<?= $row['id'] ?>)">Chegou</button>
                    </td>
                </tr>
            <?php endforeach; ?>